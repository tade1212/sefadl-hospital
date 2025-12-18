<?php
require_once 'includes/auth_check.php';
require_once '../includes/db_connect.php';

// --- File Upload Logic ---
function upload_image($file) {
    $target_dir = "../assets/images/services/";
    $filename = uniqid() . '_' . basename($file["name"]);
    $target_file = $target_dir . $filename;
    
    // Check if image file is a actual image or fake image
    $check = getimagesize($file["tmp_name"]);
    if($check === false) { return null; }

    // Check file size (e.g., 5MB limit)
    if ($file["size"] > 5000000) { return null; }

    // Allow certain file formats
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
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
    $service_name = $_POST['service_name'];
    $description = $_POST['description'];
    
    // Handle Image Upload
    $new_image_filename = null;
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $new_image_filename = upload_image($_FILES["image"]);
    }

    if ($action == 'add') {
        $sql = "INSERT INTO services (service_name, description, image_filename) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $service_name, $description, $new_image_filename);
        $stmt->execute();
    } 
    elseif ($action == 'update' && isset($_GET['id'])) {
        $service_id = $_GET['id'];
        
        if ($new_image_filename) {
            // If new image is uploaded, update filename in DB
            $sql = "UPDATE services SET service_name = ?, description = ?, image_filename = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $service_name, $description, $new_image_filename, $service_id);
        } else {
            // If no new image, update only text fields
            $sql = "UPDATE services SET service_name = ?, description = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $service_name, $description, $service_id);
        }
        $stmt->execute();
    }

} 
elseif (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) { // Handle Delete
    $service_id = $_GET['id'];
    $sql = "DELETE FROM services WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $service_id);
    $stmt->execute();
}

$conn->close();
header("location: manage_services.php");
exit();
?>