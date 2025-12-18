<?php 
// Include the header file.
require_once 'includes/header.php'; 
?>

<!-- Page Title Banner -->
<section class="page-banner" style="background-image: url('assets/images/doctors/dr2.jpg');">
    <div class="container">
        <h1>Meet Our Doctors</h1>
        <p>Our team of experienced and dedicated medical professionals.</p>
    </div>
</section>

<!-- Main Doctors Section -->
<section class="doctors-page-section">
    <div class="container">
        <div class="doctors-grid">
            <?php
            // 1. Include the database connection.
            require_once 'includes/db_connect.php';

            // 2. Define the SQL query to fetch all doctors.
            $sql = "SELECT id, full_name, specialty, photo_filename FROM doctors ORDER BY full_name ASC";
            
            // 3. Execute the query.
            $result = $conn->query($sql);

            // 4. Check if there are any results.
            if ($result && $result->num_rows > 0) {
                // 5. Loop through each doctor's record.
                while($row = $result->fetch_assoc()) {
                    // Generate the HTML for each doctor's profile card.
                    echo '<div class="doctor-card">';
                    echo '    <div class="doctor-photo">';
                    // Construct the image path correctly.
                    echo '        <img src="assets/images/doctors/' . htmlspecialchars($row["photo_filename"]) . '" alt="Photo of ' . htmlspecialchars($row["full_name"]) . '">';
                    echo '    </div>';
                    echo '    <div class="doctor-info">';
                    echo '        <h3>' . htmlspecialchars($row["full_name"]) . '</h3>';
                    echo '        <p>' . htmlspecialchars($row["specialty"]) . '</p>';
                    // This link will eventually go to a detailed profile page.
                    echo '        <a href="doctor_profile.php?id=' . $row["id"] . '" class="btn-learn-more">View Profile</a>';
                    echo '    </div>';
                    echo '</div>';
                }
            } else {
                // Display a message if no doctors are found.
                echo "<p>No doctor profiles have been added yet. Please check back later.</p>";
            }

            // 6. Close the database connection.
            $conn->close();
            ?>
        </div>
    </div>
</section>

<?php 
// Include the footer file.
require_once 'includes/footer.php'; 
?>