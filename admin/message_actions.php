<?php
require_once 'includes/auth_check.php';
require_once '../includes/db_connect.php';

if (isset($_GET['action']) && isset($_GET['id']) && is_numeric($_GET['id'])) {
    
    $action = $_GET['action'];
    $message_id = $_GET['id'];

    // --- HANDLE DELETE ---
    if ($action == 'delete') {
        $sql = "DELETE FROM contact_messages WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $message_id);
        $stmt->execute();
    }

    // --- NEW: HANDLE MARK AS READ ---
    elseif ($action == 'mark_read') {
        $sql = "UPDATE contact_messages SET is_read = 1 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $message_id);
        $stmt->execute();
    }

    // --- NEW: HANDLE MARK AS UNREAD ---
    elseif ($action == 'mark_unread') {
        $sql = "UPDATE contact_messages SET is_read = 0 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $message_id);
        $stmt->execute();
    }
}

$conn->close();
header("location: messages.php");
exit();
?>