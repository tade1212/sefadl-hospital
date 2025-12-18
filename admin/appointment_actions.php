<?php
// Include session check and database connection
require_once 'includes/auth_check.php'; // We will create this file next
require_once '../includes/db_connect.php';

// Check if the action and id are set in the URL
if (isset($_GET['action']) && isset($_GET['id']) && is_numeric($_GET['id'])) {
    
    $action = $_GET['action'];
    $appointment_id = $_GET['id'];

    // --- HANDLE DELETE ACTION ---
    if ($action == 'delete') {
        $sql = "DELETE FROM appointments WHERE id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $appointment_id);
            $stmt->execute();
            $stmt->close();
        }
    }

    // --- HANDLE UPDATE STATUS ACTION ---
    if ($action == 'update_status' && isset($_GET['status'])) {
        $status = $_GET['status'];
        // A simple security check to ensure status is one of the allowed values
        $allowed_statuses = ['Pending', 'Confirmed', 'Completed', 'Cancelled'];

        if (in_array($status, $allowed_statuses)) {
            $sql = "UPDATE appointments SET status = ? WHERE id = ?";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("si", $status, $appointment_id);
                $stmt->execute();
                $stmt->close();
            }
        }
    }

    $conn->close();
}

// Redirect back to the appointments page after the action is complete
header("location: appointments.php");
exit();
?>