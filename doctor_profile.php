<?php 
require_once 'includes/header.php'; 
require_once 'includes/db_connect.php';

// Check if an ID is present and valid in the URL.
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $doctor_id = $_GET['id'];

    // Get all doctor details including contact info
    $stmt = $conn->prepare("SELECT full_name, specialty, bio, photo_filename, phone_number, email_address FROM doctors WHERE id = ?");
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $doctor = $result->fetch_assoc();
    } else {
        $doctor = null;
    }
    $stmt->close();
} else {
    $doctor = null;
}
$conn->close();
?>

<?php if ($doctor): ?>
   

    <section class="profile-page-section">
        <div class="container">
            <!-- This .profile-layout is the main grid container -->
            <div class="profile-layout">
                
                <!-- Column 1: Contains BOTH the photo and the contact info block below it -->
                <div class="doctor-sidebar">
                    <div class="profile-photo-container">
                        <img src="assets/images/doctors/<?php echo htmlspecialchars($doctor['photo_filename']); ?>" alt="Photo of <?php echo htmlspecialchars($doctor['full_name']); ?>">
                    </div>
                    
                    <div class="doctor-contact-info">
                        <h4>Contact Information</h4>
                        <?php if (!empty($doctor['phone_number'])): ?>
                            <div class="contact-item">
                                <i class="fas fa-phone-alt"></i>
                                <span><a href="tel:<?php echo htmlspecialchars($doctor['phone_number']); ?>"><?php echo htmlspecialchars($doctor['phone_number']); ?></a></span>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($doctor['email_address'])): ?>
                            <div class="contact-item">
                                <i class="fas fa-envelope"></i>
                                <span><a href="mailto:<?php echo htmlspecialchars($doctor['email_address']); ?>"><?php echo htmlspecialchars($doctor['email_address']); ?></a></span>
                            </div>
                        <?php endif; ?>
                        <!-- <a href="appointment.php" class="btn btn-primary" style="width: 100%; margin-top: 20px; text-align:center;">Book Appointment</a> -->
                    </div>
                </div>

                <!-- Column 2: The main description / bio -->
                <div class="profile-details-container">
                    <h2>About Dr. <?php echo htmlspecialchars(explode(' ', $doctor['full_name'])[1]); ?></h2>
                    <p class="specialty"><?php echo htmlspecialchars($doctor['specialty']); ?></p>
                    <div class="bio">
                        <?php echo nl2br(htmlspecialchars($doctor['bio'])); ?>
                    </div>
                    <a href="doctors.php" class="btn btn-secondary" style="margin-top: 20px;">← Back to All Doctors</a>
                </div>

            </div>
        </div>
    </section>

<?php else: ?>
    <!-- ... (Error message code remains the same) ... -->
<?php endif; ?>

<?php 
require_once 'includes/footer.php'; 
?>