<?php 
require_once 'includes/header.php'; 
require_once 'includes/db_connect.php'; // We need the DB connection early for the dropdowns
?>

<!-- Page Title Banner -->
<!-- <section class="page-banner" style="background-image: url('assets/images/hero-banner.jpg');">
    <div class="container">
        <h1>Book an Appointment</h1>
        <p>Fill out the form below to request an appointment with one of our specialists.</p>
    </div>
</section> -->

<!-- Main Appointment Section -->
<section class="appointment-page-section">
    <div class="container form-container-narrow">
        
        <?php
        // Display status messages from the form handler.
        if (isset($_GET['status'])) {
            if ($_GET['status'] == 'success') {
                echo '<div class="alert alert-success">Your appointment request has been submitted! Our staff will contact you shortly to confirm.</div>';
            } elseif ($_GET['status'] == 'error') {
                echo '<div class="alert alert-danger">Sorry, something went wrong with your request. Please try again.</div>';
            } elseif ($_GET['status'] == 'validation_error') {
                echo '<div class="alert alert-danger">Please fill out all required fields correctly.</div>';
            }
        }
        ?>

        <form action="includes/handlers/handle_appointment.php" method="POST" class="appointment-form">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="service">Select Service</label>
                <select id="service" name="service">
                    <option value="">-- Choose a Service --</option>
                    <?php
                    // Dynamically populate services dropdown
                    $services_result = $conn->query("SELECT id, service_name FROM services ORDER BY service_name");
                    while($service = $services_result->fetch_assoc()) {
                        echo '<option value="' . $service['id'] . '">' . htmlspecialchars($service['service_name']) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <!-- <div class="form-group"> -->
                <!-- <label for="doctor">Preferred Doctor (Optional)</label> -->
                <!-- <select id="doctor" name="doctor"> -->
                    <!-- <option value="">-- Any Available Doctor --</option> -->
                <?php 
                   
                    // $doctors_result = $conn->query("SELECT id, full_name, specialty FROM doctors ORDER BY full_name");
                    //  while($doctor = $doctors_result->fetch_assoc()) {
                        //  echo '<option value="' . $doctor['id'] . '">' . htmlspecialchars($doctor['full_name']) . ' (' . htmlspecialchars($doctor['specialty']) . ')</option>';
                    //  }
                    ?> 
                <!-- </select> -->
            <!-- </div> -->
    
            <div class="form-group">
                <label for="date">Preferred Date</label>
                <input type="date" id="date" name="date" required>
            </div>
            <!-- <div class="form-group">
                <label for="message">Additional Message (Optional)</label>
                <textarea id="message" name="message" rows="5"></textarea>
            </div> -->
            <button type="submit" class="btn btn-primary" style="width: 100%;">Request Appointment</button>
        </form>
    </div>
</section>
<script src="assets/js/main.js"></script>

<?php 
$conn->close(); // Close the database connection
require_once 'includes/footer.php'; 
?>