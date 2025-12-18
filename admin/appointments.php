<?php 
require_once 'includes/admin_header.php'; 
// The header now includes db_connect.php

// --- NEW: Mark all appointments as read upon viewing this page ---
$conn->query("UPDATE appointments SET is_read = 1 WHERE is_read = 0");
?>

<div class="page-container">
    <div class="page-header">
        <h1>Appointment Requests</h1>
        <p>Review and manage all patient appointment requests.</p>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Patient Name</th>
                    <th>Contact</th>
                    <th>Preferred Date</th>
                    <th>Service</th>
                    <th>Status</th>
                    <th>Submitted On</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Update SQL to fetch the is_read status
                $sql = "SELECT 
                            a.id, a.patient_name, a.patient_email, a.patient_phone, 
                            a.preferred_date, a.status, a.submission_timestamp, a.is_read,
                            s.service_name
                        FROM appointments AS a
                        LEFT JOIN services AS s ON a.requested_service_id = s.id
                        ORDER BY a.submission_timestamp DESC";

                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        // NEW: Add a class for unread rows to make them bold
                        $row_class = $row['is_read'] == 0 ? 'unread-message' : '';

                        echo "<tr class='" . $row_class . "'>";
                        echo "<td><strong>" . htmlspecialchars($row['patient_name']) . "</strong></td>";
                        echo "<td>" . htmlspecialchars($row['patient_email']) . "<br><small>" . htmlspecialchars($row['patient_phone']) . "</small></td>";
                        echo "<td>" . date("d M, Y", strtotime($row['preferred_date'])) . "</td>";
                        echo "<td>" . htmlspecialchars($row['service_name'] ?? 'N/A') . "</td>";
                        echo "<td><span class='status-badge status-" . strtolower(htmlspecialchars($row['status'])) . "'>" . htmlspecialchars($row['status']) . "</span></td>";
                        echo "<td>" . date("d M, Y, g:i A", strtotime($row['submission_timestamp'])) . "</td>";
                        echo "<td class='actions'>";
                        // echo "<a href='#' class='btn-action btn-view' title='View Details'><i class='fas fa-eye'></i></a>";
                        echo "<a href='appointment_actions.php?action=update_status&id=" . $row['id'] . "&status=Confirmed' class='btn-action btn-confirm' title='Mark as Confirmed'><i class='fas fa-check'></i></a>";
                        echo "<a href='appointment_actions.php?action=delete&id=" . $row['id'] . "' class='btn-action btn-delete' title='Delete' onclick='return confirm(\"Are you sure you want to permanently delete this appointment request?\");'><i class='fas fa-trash-alt'></i></a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>No appointment requests found.</td></tr>";
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