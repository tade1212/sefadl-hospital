<?php
// Check if the form was submitted using the POST method.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Include the database connection file.
    require_once '../db_connect.php';

    // 2. Get the form data and sanitize it.
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    // 3. Validate the data (basic validation).
    if (!empty($name) && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($message)) {
        
        // 4. Prepare the SQL INSERT statement to prevent SQL injection.
        $sql = "INSERT INTO contact_messages (sender_name, sender_email, subject, message) VALUES (?, ?, ?, ?)";
        
        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssss", $name, $email, $subject, $message);
            
            // 5. Execute the statement.
            if ($stmt->execute()) {
                // If successful, redirect to the contact page with a success message.
                header("location: ../../contact.php?status=success");
                exit();
            } else {
                // If execution fails, redirect with an error message.
                header("location: ../../contact.php?status=error");
                exit();
            }
            $stmt->close();
        }
    } else {
        // If validation fails, redirect with a validation error message.
        header("location: ../../contact.php?status=validation_error");
        exit();
    }
    
    $conn->close();

} else {
    // If the page was accessed directly without POST data, redirect to the homepage.
    header("location: ../../index.php");
    exit();
}
?>