<?php 
require_once 'includes/admin_header.php'; 
require_once '../includes/db_connect.php';
?>

<div class="page-container">
    <div class="page-header">
        <h1>Manage Doctors</h1>
        <p>Add, edit, or delete doctor profiles.</p>
        <a href="edit_doctor.php" class="btn-add-new">
            <i class="fas fa-plus"></i> Add New Doctor
        </a>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Photo</th>
                    <th>Full Name</th>
                    <th>Specialty</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT id, full_name, specialty, photo_filename FROM doctors ORDER BY full_name ASC";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td><img src='../assets/images/doctors/" . htmlspecialchars($row['photo_filename']) . "' alt='" . htmlspecialchars($row['full_name']) . "' class='table-thumb'></td>";
                        echo "<td><strong>" . htmlspecialchars($row['full_name']) . "</strong></td>";
                        echo "<td>" . htmlspecialchars($row['specialty']) . "</td>";
                        echo "<td class='actions'>";
                        echo "<a href='edit_doctor.php?id=" . $row['id'] . "' class='btn-action btn-edit' title='Edit'><i class='fas fa-pencil-alt'></i></a>";
                        echo "<a href='doctor_actions.php?action=delete&id=" . $row['id'] . "' class='btn-action btn-delete' title='Delete' onclick='return confirm(\"Are you sure you want to delete this doctor profile?\");'><i class='fas fa-trash-alt'></i></a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No doctors found. Add one to get started.</td></tr>";
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