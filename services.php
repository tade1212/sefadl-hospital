<?php 
require_once 'includes/header.php'; 
?>

<!-- Page Title Banner -->
<section class="page-banner" style="background-image: url('assets/images/services/ser1.jpg');">
    <div class="container">
        <h1>Our Medical Services</h1>
        <p>Comprehensive care across a wide range of specialties.</p>
    </div>
</section>

<!-- Main Services Section -->
<section class="services-page-section">
    <div class="container">
        <div class="services-grid-fullpage">
            <?php
            // 1. Include the database connection file.
            require_once 'includes/db_connect.php';

            // 2. Update the SQL query to fetch the image_filename.
            $sql = "SELECT id, service_name, description, image_filename FROM services ORDER BY service_name ASC";
            
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // 3. The HTML for the card is now changed to include an <img> tag.
                    echo '<div class="service-card-image">';
                    echo '    <div class="card-image-container">';
                    echo '        <img src="assets/images/services/' . htmlspecialchars($row["image_filename"]) . '" alt="' . htmlspecialchars($row["service_name"]) . '">';
                    echo '    </div>';
                    echo '    <div class="card-content">';
                    echo '        <h3>' . htmlspecialchars($row["service_name"]) . '</h3>';
                    echo '        <p>' . htmlspecialchars(substr($row["description"], 0, 100)) . '...</p>'; // Show a short excerpt
                    echo '        <a href="service_detail.php?id=' . $row["id"] . '" class="btn-learn-more">Learn More</a>';
                    echo '    </div>';
                    echo '</div>';
                }
            } else {
                echo "<p>No medical services have been added yet. Please check back later.</p>";
            }

            $conn->close();
            ?>
        </div>
    </div>
</section>

<?php 
require_once 'includes/footer.php'; 
?>