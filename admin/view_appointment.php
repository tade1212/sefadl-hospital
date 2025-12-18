<?php 
require_once 'includes/admin_header.php'; 
require_once '../includes/db_connect.php';

$appointment = null; // Start with a null value

// 1. Check if an ID is provided and is a valid integer
if (isset($_GET['id']) && filter_var($_GET['id'])) {
    
    $appointment_id = $_GET['id'];

    // 2. Define the SQL query with LEFT JOINs to get full names
    $sql = "SELECT 
                a.id, a.patient_name, a.patient_email, a.patient_phone, 
                a.preferred_date, a.status, a.submission_timestamp, a.message,
                s.service_name,
                d.full_name AS doctor_name
            FROM appointments AS a
            LEFT JOIN services AS s ON a.requested_service_id = s.id
            LEFT JOIN doctors AS d ON a.preferred_doctor_id = d.id
            WHERE a.id = ?";

    // 3. Prepare, bind, execute, and fetch the result
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $appointment_id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows === 1) {
                $appointment = $result->fetch_assoc();
            }
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!-- Main container for the page content -->
<div class="page-container">

    <!-- Page Header -->
    <div class="page-header">
        <h1>Appointment Details</h1>
        <a href="appointments.php" class="btn-add-new">← Back to Appointments</a>
    </div>

    <?php if ($appointment): ?>
        <!-- Details Layout Container -->
        <div class="details-container">
            
            <div class="detail-section">
                <h3>Patient Information</h3>
                <p><strong>Patient Name:</strong> <?php echo htmlspecialchars($appointment['patient_name']); ?></p>
                <p><strong>Email Address:</strong> <a href="mailto:<?php echo htmlspecialchars($appointment['patient_email']); ?>"><?php echo htmlspecialchars($appointment['patient_email']); ?></a></p>
                <p><strong>Phone Number:</strong> <a href="tel:<?php echo htmlspecialchars($appointment['patient_phone']); ?>"><?php echo htmlspecialchars($appointment['patient_phone']); ?></a></p>
            </div>

            <div class="detail-section">
                <h3>Appointment Details</h3>
                <p><strong>Status:</strong> <span class="status-badge status-<?php echo strtolower(htmlspecialchars($appointment['status'])); ?>"><?php echo htmlspecialchars($appointment['status']); ?></span></p>
                <p><strong>Requested Date:</strong> <?php echo date("F d, Y", strtotime($appointment['preferred_date'])); ?></p>
                <p><strong>Requested Service:</strong> <?php echo htmlspecialchars($appointment['service_name'] ?? 'N/A'); ?></p>
                <p><strong>Preferred Doctor:</strong> <?php echo htmlspecialchars($appointment['doctor_name'] ?? 'Any Available'); ?></p>
                <p><strong>Submitted On:</strong> <?php echo date("F d, Y, g:i A", strtotime($appointment['submission_timestamp'])); ?></p>
            </div>
            
            <?php if (!empty($appointment['message'])): ?>
                <div class="detail-section">
                    <h3>Patient Message</h3>
                    <div class="message-box">
                        <p><?php echo nl2br(htmlspecialchars($appointment['message'])); ?></p>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    <?php else: ?>
        <div class="text-center" style="padding: 40px;">
            <h2>Appointment Not Found</h2>
            <p>The requested appointment ID (ID: <?php echo htmlspecialchars($_GET['id'] ?? 'None'); ?>) does not exist or could not be found.</p>
        </div>
    <?php endif; ?>

</div>

<?php 
require_once 'includes/admin_footer.php'; 
?>