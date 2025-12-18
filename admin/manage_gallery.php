<?php 
require_once 'includes/admin_header.php'; 
require_once '../includes/db_connect.php';
?>

<div class="page-container">
    <div class="page-header">
        <h1>Manage Gallery</h1>
        <p>Upload new images or delete existing ones from the gallery.</p>
        <!-- The "Add" button links to our edit page, but without an ID -->
        <a href="edit_gallery_image.php" class="btn-add-new">
            <i class="fas fa-plus"></i> Add New Image
        </a>
    </div>

    <div class="gallery-management-grid">
        <?php
        $sql = "SELECT id, image_filename, caption, category FROM gallery_images ORDER BY upload_date DESC";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='gallery-manage-card'>";
                echo "    <img src='../assets/images/gallery/" . htmlspecialchars($row['image_filename']) . "' alt='" . htmlspecialchars($row['caption']) . "'>";
                echo "    <div class='card-info'>";
                echo "        <p><strong>Caption:</strong> " . htmlspecialchars($row['caption']) . "</p>";
                echo "        <p><strong>Category:</strong> " . htmlspecialchars($row['category']) . "</p>";
                echo "    </div>";
                echo "    <div class='card-actions'>";
                // Edit link (optional for future, for now we focus on Add/Delete)
                // echo "        <a href='edit_gallery_image.php?id=" . $row['id'] . "' class='btn-action-text btn-edit'>Edit</a>";
                echo "        <a href='gallery_actions.php?action=delete&id=" . $row['id'] . "' class='btn-action-text btn-delete' onclick='return confirm(\"Are you sure you want to delete this image?\");'>Delete</a>";
                echo "    </div>";
                echo "</div>";
            }
        } else {
            echo "<p>No images found in the gallery. Add one to get started.</p>";
        }
        $conn->close();
        ?>
    </div>
</div>

<?php 
require_once 'includes/admin_footer.php'; 
?>