<?php 
require_once 'includes/admin_header.php'; 
require_once '../includes/db_connect.php';

$message = null;

// Check if an ID is provided and is a valid number
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $message_id = $_GET['id'];

    // --- Mark this message as read ---
    // This query runs every time the page is viewed
    $stmt_update = $conn->prepare("UPDATE contact_messages SET is_read = 1 WHERE id = ?");
    $stmt_update->bind_param("i", $message_id);
    $stmt_update->execute();
    $stmt_update->close();
    // --- End of update logic ---


    // SQL query to fetch all details for this message
    $sql = "SELECT id, sender_name, sender_email, subject, message, received_at FROM contact_messages WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $message_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $message = $result->fetch_assoc();
        }
        $stmt->close();
    }
}
?>

<!-- Main container with styles -->
<div style="background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">

    <!-- Page Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid #eee;">
        <h1 style="font-family: 'Montserrat', sans-serif; margin: 0;">Message Details</h1>
        <a href="messages.php" style="background-color: #231F20; color: #fff; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: 700;">← Back to Messages</a>
    </div>

    <?php if ($message): ?>
        <!-- Details Layout -->
        <div style="max-width: 900px; margin: 0 auto; line-height: 1.8; font-size: 1.1rem;">
            
            <h3 style="font-family: 'Montserrat', sans-serif; font-size: 1.5rem; margin-bottom: 20px; border-bottom: 2px solid #f4f4f4; padding-bottom: 10px;">Sender Information</h3>
            <p><strong>From:</strong> <?php echo htmlspecialchars($message['sender_name']); ?></p>
            <p><strong>Email:</strong> <a href="mailto:<?php echo htmlspecialchars($message['sender_email']); ?>"><?php echo htmlspecialchars($message['sender_email']); ?></a></p>
            <p><strong>Received:</strong> <?php echo date("F d, Y, g:i A", strtotime($message['received_at'])); ?></p>

            <h3 style="font-family: 'Montserrat', sans-serif; font-size: 1.5rem; margin-top: 40px; margin-bottom: 20px; border-bottom: 2px solid #f4f4f4; padding-bottom: 10px;">Message Content</h3>
            <p><strong>Subject:</strong> <?php echo htmlspecialchars($message['subject']); ?></p>
            
            <div style="background-color: #f8f9fa; border-left: 4px solid #00A0B0; padding: 20px; border-radius: 5px;">
                <p style="margin: 0; white-space: pre-wrap;"><?php echo htmlspecialchars($message['message']); ?></p>
            </div>
        </div>
    <?php else: ?>
        <div style="text-align: center; padding: 40px;">
            <h2>Message Not Found</h2>
            <p>The requested message ID does not exist or could not be found.</p>
        </div>
    <?php endif; ?>

</div>

<?php 
$conn->close();
require_once 'includes/admin_footer.php'; 
?>