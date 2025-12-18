
<?php
require_once 'includes/auth_check.php';
require_once '../includes/db_connect.php';

// --- File Upload Logic for Gallery Images ---
function upload_gallery_image($file) {
    $target_dir = "../assets/images/gallery/"; // The directory for gallery images
    $filename = uniqid() . '_' . basename($file["name"]);
    $target_file = $target_dir . $filename;
    
    $check = getimagesize($file["tmp_name"]);
    if($check === false) { return null; }
    if ($file["size"] > 5000000) { return null; } // 5MB limit
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if(!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif','jfif'])) { return null; }

    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return $filename;
    } else {
        return null;
    }
}

// --- Main Action Handling ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['action']) && $_GET['action'] == 'add') {
    $caption = $_POST['caption'];
    $category = $_POST['category'];
    
    $image_filename = null;
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $image_filename = upload_gallery_image($_FILES["image"]);
    }

    // Only insert if the image was successfully uploaded
    if ($image_filename) {
        $sql = "INSERT INTO gallery_images (image_filename, caption, category) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $image_filename, $caption, $category);
        $stmt->execute();
    }

} 
elseif (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) { // Handle Delete
    $image_id = $_GET['id'];

    // Optional but recommended: Delete the actual file from the server
    $stmt_select = $conn->prepare("SELECT image_filename FROM gallery_images WHERE id = ?");
    $stmt_select->bind_param("i", $image_id);
    $stmt_select->execute();
    $result = $stmt_select->get_result();
    if($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $file_to_delete = '../assets/images/gallery/' . $row['image_filename'];
        if (file_exists($file_to_delete)) {
            unlink($file_to_delete); // Deletes the file
        }
    }
    $stmt_select->close();

    // Now, delete the record from the database
    $stmt_delete = $conn->prepare("DELETE FROM gallery_images WHERE id = ?");
    $stmt_delete->bind_param("i", $image_id);
    $stmt_delete->execute();
}

$conn->close();
header("location: manage_gallery.php");
exit();
?>