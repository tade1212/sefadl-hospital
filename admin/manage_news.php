<?php 
require_once 'includes/admin_header.php'; 
require_once '../includes/db_connect.php';
?>

<div class="page-container">
    <div class="page-header">
        <h1>Manage News</h1>
        <p>Add, edit, or delete news articles and health tips.</p>
        <a href="edit_news.php" class="btn-add-new">
            <i class="fas fa-plus"></i> Add New Article
        </a>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Published On</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT id, title, publish_date, featured_image_filename FROM news_articles ORDER BY publish_date DESC";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td><img src='../assets/images/news/" . htmlspecialchars($row['featured_image_filename']) . "' alt='" . htmlspecialchars($row['title']) . "' class='table-thumb'></td>";
                        echo "<td><strong>" . htmlspecialchars($row['title']) . "</strong></td>";
                        echo "<td>" . date("d M, Y", strtotime($row['publish_date'])) . "</td>";
                        echo "<td class='actions'>";
                        echo "<a href='edit_news.php?id=" . $row['id'] . "' class='btn-action btn-edit' title='Edit'><i class='fas fa-pencil-alt'></i></a>";
                        echo "<a href='news_actions.php?action=delete&id=" . $row['id'] . "' class='btn-action btn-delete' title='Delete' onclick='return confirm(\"Are you sure you want to delete this article?\");'><i class='fas fa-trash-alt'></i></a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No news articles found.</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php 
require_once 'includes/admin_footer.php'; 
?>