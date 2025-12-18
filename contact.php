<?php 
require_once 'includes/header.php'; 
?>

<!-- Page Title Banner -->
<section class="page-banner" style="background-image: url('assets/images/gallery/img1.jpg');">
    <div class="container">
        <h1>Contact Us</h1>
        <p>We are here to help. Get in touch with us today.</p>
    </div>
</section>

<!-- Main Contact Section -->
<section class="contact-page-section">
    <div class="container">

        <?php
        // Check for a status message in the URL (from the form handler) to display success or error alerts.
        if (isset($_GET['status'])) {
            if ($_GET['status'] == 'success') {
                echo '<div class="alert alert-success">Your message has been sent successfully! We will get back to you shortly.</div>';
            } elseif ($_GET['status'] == 'error') {
                echo '<div class="alert alert-danger">Sorry, something went wrong. Please try again later.</div>';
            } elseif ($_GET['status'] == 'validation_error') {
                echo '<div class="alert alert-danger">Please fill in all required fields correctly.</div>';
            }
        }
        ?>

        <!-- This is the new parent grid for the side-by-side layout -->
        <div class="contact-layout-grid">

            <!-- Column 1: Contains both the form and the contact info below it -->
            <div class="contact-content-wrapper">
                
                <div class="contact-form-container">
                    <h3>Send us a Message</h3>
                    <form action="includes/handlers/handle_contact_form.php" method="POST" class="contact-form">
                        <div class="form-group">
                            <label for="name">Your Name</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Your Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" id="subject" name="subject">
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" rows="6" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>

                <div class="contact-info-container">
                    <h3>Hospital Information</h3>
                    <div class="contact-info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <p><strong>Address:</strong><br>MwtsaeWerki,Adigrat,Ethiopia</p>
                    </div>
                    <div class="contact-info-item">
                        <i class="fas fa-phone-alt"></i>
                        <p><strong>Phone:</strong><br><a href="tel:+251966226586">+251966226586</a></p>
                    </div>
                    <div class="contact-info-item">
                        <i class="fas fa-envelope"></i>
                        <p><strong>Email:</strong><br><a href="mailto:sefadilhospital@gmali.com">sefadilhospital@gmail.com</a></p>
                    </div>
                </div>
            </div>

            <!-- Column 2: The Map -->
            <div class="map-container">
                <!-- IMPORTANT: Replace the src="" value with the one for your actual hospital location from Google Maps -->
                <!-- <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.617325605727!2d-73.98784438459378!3d40.74844097932799!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c259a9b3117469%3A0xd134e199a405a163!2sEmpire%20State%20Building!5e0!3m2!1sen!2sus!4v1616001234567!5m2!1sen!2sus" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe> -->
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3393.5237283144547!2d39.46192471002175!3d14.264621586125255!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x166c85002270f221%3A0xe4e54c9b84045e75!2sSefadl%20primary%20hospital!5e1!3m2!1sen!2set!4v1758454337158!5m2!1sen!2set" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

        </div> <!-- End of .contact-layout-grid -->
    </div>
</section>

<?php 
require_once 'includes/footer.php'; 
?>