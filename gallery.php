<?php 
require_once 'includes/header.php'; 
require_once 'includes/db_connect.php';
?>

<!-- Page Title Banner -->
<section class="page-banner" style="background-image: url('assets/images/gallery/img1.jpg');">
    <div class="container">
        <h1>Our Gallery</h1>
        <p>A glimpse into our facilities, team, and community events.</p>
    </div>
</section>

<!-- Main Gallery Section -->
<section class="gallery-page-section">
    <div class="container">
        
        <!-- Filter Buttons -->
        <div id="gallery-filters" class="gallery-filters">
            <button class="filter-btn active" data-filter="*">All</button>
            <button class="filter-btn" data-filter="Facilities">Facilities</button>
            <button class="filter-btn" data-filter="Team">Our Team</button>
            <button class="filter-btn" data-filter="Events">Events</button>
        </div>

        <div class="gallery-grid">
            <?php
            // Fetch all gallery images from the database
            $sql = "SELECT image_filename, caption, category FROM gallery_images ORDER BY upload_date DESC";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // Output a link for each image, with data attributes for filtering and the lightbox
                    echo '<a href="assets/images/gallery/' . htmlspecialchars($row['image_filename']) . '" 
                           class="gallery-item ' . htmlspecialchars($row['category']) . '" 
                           data-category="' . htmlspecialchars($row['category']) . '"
                           data-caption="' . htmlspecialchars($row['caption']) . '">';
                    echo '    <img src="assets/images/gallery/' . htmlspecialchars($row['image_filename']) . '" alt="' . htmlspecialchars($row['caption']) . '">';
                    echo '    <div class="overlay"><i class="fas fa-search-plus"></i></div>';
                    echo '</a>';
                }
            } else {
                echo '<p>No images have been added to the gallery yet.</p>';
            }
            $conn->close();
            ?>
        </div>
    </div>
</section>

<!-- Lightbox Structure (Hidden by default with CSS) -->
<div id="lightbox" class="lightbox">
    <span class="lightbox-close">&times;</span>
    <img class="lightbox-content" id="lightbox-img">
    <div id="lightbox-caption" class="lightbox-caption"></div>
</div>


<?php 
require_once 'includes/footer.php'; 
?>