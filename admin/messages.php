<?php 
require_once 'includes/admin_header.php'; 
require_once '../includes/db_connect.php';

// We no longer mark all as read here, this will be done by the view page
// $conn->query("UPDATE contact_messages SET is_read = 1 WHERE is_read = 0");
?>

<div class="page-container">
    <div class="page-header">
        <h1>Contact Form Messages</h1>
        <p>Review all messages submitted through the website's contact form.</p>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Sender Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <!-- <th>Message</th> -->
                    <th>Received On</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT id, sender_name, sender_email, subject, message, received_at, is_read FROM contact_messages ORDER BY received_at DESC";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $short_message = substr($row['message'], 0, 70) . (strlen($row['message']) > 70 ? '...' : '');
                        
                        // Add a class for unread rows to make them bold
                        $row_class = $row['is_read'] == 0 ? 'unread-message' : '';

                        echo "<tr class='" . $row_class . "'>";
                        echo "<td><strong>" . htmlspecialchars($row['sender_name']) . "</strong></td>";
                        echo "<td><a href='mailto:" . htmlspecialchars($row['sender_email']) . "'>" . htmlspecialchars($row['sender_email']) . "</a></td>";
                        echo "<td>" . htmlspecialchars($row['subject']) . "</td>";
                        // echo "<td>" . htmlspecialchars($short_message) . "</td>";
                        echo "<td>" . date("d M, Y, g:i A", strtotime($row['received_at'])) . "</td>";
                        echo "<td class='actions'>";
                        
                        // 1. View Details Link
                        echo "<a href='view_message.php?id=" . $row['id'] . "' class='btn-action btn-view' title='View Full Message'><i class='fas fa-eye'></i></a>";

                        // 2. Mark as Read/Unread Toggle Link
                        if ($row['is_read'] == 0) {
                            // If unread, show a button to mark as read
                            echo "<a href='message_actions.php?action=mark_read&id=" . $row['id'] . "' class='btn-action btn-confirm' title='Mark as Read'><i class='fas fa-envelope-open'></i></a>";
                        } else {
                            // If read, show a button to mark as unread
                            echo "<a href='message_actions.php?action=mark_unread&id=" . $row['id'] . "' class='btn-action btn-mark-unread' title='Mark as Unread'><i class='fas fa-envelope'></i></a>";
                        }
                        
                        // 3. Delete Link
                        echo "<a href='message_actions.php?action=delete&id=" . $row['id'] . "' class='btn-action btn-delete' title='Delete' onclick='return confirm(\"Are you sure you want to delete this message?\");'><i class='fas fa-trash-alt'></i></a>";

                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>No messages found.</td></tr>";
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