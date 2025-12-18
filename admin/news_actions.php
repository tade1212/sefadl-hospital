<?php
require_once 'includes/auth_check.php';
require_once '../includes/db_connect.php';

// --- File Upload Logic for News Images ---
function upload_news_image($file) {
    $target_dir = "../assets/images/news/"; // The directory for news images
    $filename = uniqid() . '_' . basename($file["name"]);
    $target_file = $target_dir . $filename;
    
    $check = getimagesize($file["tmp_name"]);
    if($check === false) { return null; }
    if ($file["size"] > 5000000) { return null; } // 5MB limit
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if(!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) { return null; }

    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return $filename;
    } else {
        return null;
    }
}

// --- Main Action Handling ---
if ($_SERVER["REQUEST_METHOD"] == "POST") { // Handle Add/Update
    $action = $_GET['action'] ?? '';
    $title = $_POST['title'];
    $content = $_POST['content'];
    $excerpt = $_POST['excerpt'];
    
    $new_image_filename = null;
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $new_image_filename = upload_news_image($_FILES["image"]);
    }

    if ($action == 'add') {
        $sql = "INSERT INTO news_articles (title, content, excerpt, featured_image_filename) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $title, $content, $excerpt, $new_image_filename);
        $stmt->execute();
    } 
    elseif ($action == 'update' && isset($_GET['id'])) {
        $article_id = $_GET['id'];
        
        if ($new_image_filename) {
            $sql = "UPDATE news_articles SET title = ?, content = ?, excerpt = ?, featured_image_filename = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $title, $content, $excerpt, $new_image_filename, $article_id);
        } else {
            $sql = "UPDATE news_articles SET title = ?, content = ?, excerpt = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $title, $content, $excerpt, $article_id);
        }
        $stmt->execute();
    }

} 
elseif (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) { // Handle Delete
    $article_id = $_GET['id'];
    $sql = "DELETE FROM news_articles WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $article_id);
    $stmt->execute();
}

$conn->close();
header("location: manage_news.php");
exit();
?>