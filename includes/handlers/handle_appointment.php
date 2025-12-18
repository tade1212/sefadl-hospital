<?php
// Check if the form was submitted using the POST method.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Include the database connection.
    require_once '../db_connect.php';

    // 2. Get and sanitize form data.
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $date = trim($_POST['date']);
    $message = trim($_POST['message']);

    // --- THIS IS THE CORRECTED PART ---
    
    // Handle the Service ID: ensure it's a valid integer or NULL.
    $service_id = filter_var($_POST['service'], FILTER_VALIDATE_INT);
    if ($service_id === false) {
        $service_id = null;
    }

    // Handle the Doctor ID: ensure it's a valid integer or NULL if "Any Available" is chosen.
    $doctor_id = filter_var($_POST['doctor'], FILTER_VALIDATE_INT);
    if ($doctor_id === false) {
        $doctor_id = null; // Correctly set to NULL for the database
    }
    
    // --- END OF CORRECTION ---

    // 3. Basic validation.
    if (!empty($name) && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($phone) && !empty($date)) {
        
        // 4. Prepare the SQL INSERT statement.
        $sql = "INSERT INTO appointments (patient_name, patient_email, patient_phone, requested_service_id, preferred_doctor_id, preferred_date, message) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        if ($stmt = $conn->prepare($sql)) {
            
            // CORRECTED: Bind parameters with the correct types ('i' for integers).
            $stmt->bind_param(
                "sssiiss", // s=string, i=integer
                $name,
                $email,
                $phone,
                $service_id,
                $doctor_id,
                $date,
                $message
            );
            
            // 5. Execute the statement.
            if ($stmt->execute()) {
                header("location: ../../appointment.php?status=success");
                exit();
            } else {
                // For debugging, you could show the error: error_log($stmt->error);
                header("location: ../../appointment.php?status=error");
                exit();
            }
            $stmt->close();
        }
    } else {
        header("location: ../../appointment.php?status=validation_error");
        exit();
    }
    
    $conn->close();

} else {
    // Redirect if accessed directly.
    header("location: ../../index.php");
    exit();
}
?>