<?php 
require_once 'includes/admin_header.php'; 
require_once '../includes/db_connect.php';
?>

<div class="page-container">
    <div class="page-header">
        <h1>Manage Services</h1>
        <p>Add, edit, or delete hospital services.</p>
        <a href="edit_service.php" class="btn-add-new">
            <i class="fas fa-plus"></i> Add New Service
        </a>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Service Name</th>
                    <th>Description Excerpt</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT id, service_name, description, image_filename FROM services ORDER BY service_name ASC";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $excerpt = substr($row['description'], 0, 100) . '...';
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td><img src='../assets/images/services/" . htmlspecialchars($row['image_filename']) . "' alt='" . htmlspecialchars($row['service_name']) . "' class='table-thumb'></td>";
                        echo "<td><strong>" . htmlspecialchars($row['service_name']) . "</strong></td>";
                        echo "<td>" . htmlspecialchars($excerpt) . "</td>";
                        echo "<td class='actions'>";
                        echo "<a href='edit_service.php?id=" . $row['id'] . "' class='btn-action btn-edit' title='Edit'><i class='fas fa-pencil-alt'></i></a>";
                        echo "<a href='service_actions.php?action=delete&id=" . $row['id'] . "' class='btn-action btn-delete' title='Delete' onclick='return confirm(\"Are you sure you want to delete this service? This action cannot be undone.\");'><i class='fas fa-trash-alt'></i></a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No services found. Add one to get started.</td></tr>";
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