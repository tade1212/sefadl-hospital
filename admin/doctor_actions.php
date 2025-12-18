<?php
require_once 'includes/auth_check.php';
require_once '../includes/db_connect.php';

// --- File Upload Logic for Doctor Photos ---
function upload_doctor_photo($file) {
    $target_dir = "../assets/images/doctors/"; // The directory for doctor photos
    $filename = uniqid() . '_' . basename($file["name"]);
    $target_file = $target_dir . $filename;
    
    $check = getimagesize($file["tmp_name"]);
    if($check === false) { return null; }

    if ($file["size"] > 5000000) { return null; } // 5MB limit

    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if(!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
        return null;
    }

    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return $filename;
    } else {
        return null;
    }
}

// --- Main Action Handling ---
if ($_SERVER["REQUEST_METHOD"] == "POST") { // Handle Add/Update
    $action = $_GET['action'] ?? '';
    $full_name = $_POST['full_name'];
    $specialty = $_POST['specialty'];
    $bio = $_POST['bio'];
    $phone_number = $_POST['phone_number'];
    $email_address = $_POST['email_address'];
    
    $new_photo_filename = null;
    if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0) {
        $new_photo_filename = upload_doctor_photo($_FILES["photo"]);
    }

    if ($action == 'add') {
        $sql = "INSERT INTO doctors (full_name, specialty, bio, phone_number, email_address, photo_filename) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $full_name, $specialty, $bio, $phone_number, $email_address, $new_photo_filename);
        $stmt->execute();
    } 
    elseif ($action == 'update' && isset($_GET['id'])) {
        $doctor_id = $_GET['id'];
        
        if ($new_photo_filename) {
            $sql = "UPDATE doctors SET full_name = ?, specialty = ?, bio = ?, phone_number = ?, email_address = ?, photo_filename = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssi", $full_name, $specialty, $bio, $phone_number, $email_address, $new_photo_filename, $doctor_id);
        } else {
            $sql = "UPDATE doctors SET full_name = ?, specialty = ?, bio = ?, phone_number = ?, email_address = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssi", $full_name, $specialty, $bio, $phone_number, $email_address, $doctor_id);
        }
        $stmt->execute();
    }

} 
elseif (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) { // Handle Delete
    $doctor_id = $_GET['id'];
    $sql = "DELETE FROM doctors WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
}

$conn->close();
header("location: manage_doctors.php");
exit();
?>