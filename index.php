<?php 
require_once 'includes/header.php'; 
require_once 'includes/db_connect.php';
?>

<!-- HERO SECTION -->
<section class="hero-section">
    <!-- ... (No change here) ... -->
    <div class="container">
        <div class="hero-content">
        <h1>Compassionate Care, Advanced Medicine.</h1>
        <p class="par">Your trusted partner in health and wellness.</p>
        </div>
        <div class="hero-buttons">
            <a href="services.php" class="btn btn-primary">View Our Services</a>
            <a href="doctors.php" class="btn btn-secondary">Find a Doctor</a>
        </div>
    </div>
    
</section>

<!-- SERVICES SECTION (Flexbox Layout & NOW WITH IMAGES) -->
<section class="home-section home-services">
    <div class="container">
        <div class="section-title">
            <h2>Our Core Medical Services</h2>
            <p>Providing expert care across key specialties to ensure your well-being.</p>
        </div>
        <div class="flex-container">
            <?php
            // 1. UPDATE THE SQL QUERY to fetch the image_filename
            $sql_services = "SELECT id, service_name, description, image_filename FROM services ORDER BY service_name ASC LIMIT 4";
            $result_services = $conn->query($sql_services);

            if ($result_services && $result_services->num_rows > 0) {
                while($row = $result_services->fetch_assoc()) {
                    // 2. USE THE NEW IMAGE-BASED CARD HTML (.service-card-image)
                    echo '<div class="service-card-image">'; // Use the same class as services.php
                    echo '    <div class="card-image-container">';
                    echo '        <img src="assets/images/services/' . htmlspecialchars($row["image_filename"]) . '" alt="' . htmlspecialchars($row["service_name"]) . '">';
                    echo '    </div>';
                    echo '    <div class="card-content">';
                    echo '        <h3>' . htmlspecialchars($row["service_name"]) . '</h3>';
                    // No need to shorten the description on the homepage card
                    // echo '        <p>' . htmlspecialchars(substr($row["description"], 0, 100)) . '...</p>';
                    echo '        <a href="service_detail.php?id=' . $row["id"] . '" class="btn-learn-more">Learn More</a>';
                    echo '    </div>';
                    echo '</div>';
                }
            }
            ?>
        </div>
        <div class="section-cta">
            <a href="services.php" class="btn btn-primary">View All Services</a>
        </div>
    </div>
</section>
<!-- WHY CHOOSE US SECTION (Flexbox Layout) -->
<section class="home-section home-why-choose-us">
    <!-- ... (No change here) ... -->
    <div class="container">
        <div class="section-title">
            <h2>Why Choose Sefadil Hospital?</h2>
        </div>
        <div class="flex-container">
            <div class="flex-card feature-card">
                <div class="card-icon"><i class="fas fa-user-md"></i></div>
                <h3>Expert Doctors</h3>
                <p>Our team consists of highly skilled, board-certified physicians dedicated to your health.</p>
            </div>
            <div class="flex-card feature-card">
                <div class="card-icon"><i class="fas fa-laptop-medical"></i></div>
                <h3>Modern Technology</h3>
                <p>We use the latest medical technology for accurate diagnoses and effective treatments.</p>
            </div>
            <div class="flex-card feature-card">
                <div class="card-icon"><i class="fas fa-heart"></i></div>
                <h3>Patient-Centered Care</h3>
                <p>Your comfort, needs, and well-being are at the center of every decision we make.</p>
            </div>
        </div>
    </div>
</section>

<!-- DOCTORS PREVIEW SECTION (Flexbox Layout) -->
<section class="home-section home-doctors-preview">
    <!-- ... (No change here) ... -->
    <div class="container">
        <div class="section-title">
            <h2>Meet Our Expert Team</h2>
            <p>A selection of our dedicated and experienced medical professionals.</p>
        </div>
        <div class="flex-container">
            <?php
            $sql_doctors = "SELECT id, full_name, specialty, photo_filename FROM doctors ORDER BY RAND() LIMIT 4";
            $result_doctors = $conn->query($sql_doctors);
            if ($result_doctors && $result_doctors->num_rows > 0) {
                while($row = $result_doctors->fetch_assoc()) {
                    echo '<div class="doctor-card">';
                    echo '    <div class="doctor-photo">';
                    echo '        <img src="assets/images/doctors/' . htmlspecialchars($row["photo_filename"]) . '" alt="Photo of ' . htmlspecialchars($row["full_name"]) . '">';
                    echo '    </div>';
                    echo '    <div class="doctor-info">';
                    echo '        <h3>' . htmlspecialchars($row["full_name"]) . '</h3>';
                    echo '        <p>' . htmlspecialchars($row["specialty"]) . '</p>';
                    echo '        <a href="doctor_profile.php?id=' . $row["id"] . '" class="btn-learn-more">View Profile</a>';
                    echo '    </div>';
                    echo '</div>';
                }
            }
            ?>
        </div>
        <div class="section-cta">
            <a href="doctors.php" class="btn btn-primary">Meet The Full Team</a>
        </div>
    </div>
</section>

<!-- RECENT NEWS SECTION - NEW -->
<section class="home-section home-recent-news">
    <div class="container">
        <div class="section-title">
            <h2>News & Health Tips</h2>
            <p>Stay informed with the latest updates and advice from our medical experts.</p>
        </div>
        <div class="news-grid-home">
            <?php
            // Fetch the 3 most recent news articles
            $sql_news = "SELECT id, title, excerpt, publish_date, featured_image_filename FROM news_articles ORDER BY publish_date DESC LIMIT 3";
            $result_news = $conn->query($sql_news);

            if ($result_news && $result_news->num_rows > 0) {
                while($row = $result_news->fetch_assoc()) {
                    $formatted_date = date("F j, Y", strtotime($row['publish_date']));
                    // We can reuse the .news-card style from the main news page
                    echo '<div class="news-card">';
                    echo '    <a href="news_detail.php?id=' . $row['id'] . '" class="news-card-image-link">';
                    echo '        <img src="assets/images/news/' . htmlspecialchars($row["featured_image_filename"]) . '" alt="' . htmlspecialchars($row["title"]) . '">';
                    echo '    </a>';
                    echo '    <div class="news-card-content">';
                    echo '        <p class="meta">' . $formatted_date . '</p>';
                    echo '        <h3><a href="news-detail.php?id=' . $row['id'] . '">' . htmlspecialchars($row["title"]) . '</a></h3>';
                    echo '        <p class="excerpt">' . htmlspecialchars($row["excerpt"]) . '</p>';
                    echo '        <a href="news_detail.php?id=' . $row['id'] . '" class="btn-learn-more">Read More</a>';
                    echo '    </div>';
                    echo '</div>';
                }
            }
            ?>
        </div>
        <div class="section-cta">
            <a href="news.php" class="btn btn-primary">Read All News</a>
        </div>
    </div>
</section>

<!-- GALLERY PREVIEW SECTION - NEW -->
<section class="home-section home-gallery-preview">
    <div class="container">
        <div class="section-title">
            <h2>Images  of Our Hospital</h2>
        </div>
        <div class="gallery-grid-home">
            <?php
            // Fetch 4 random images from the gallery
            $sql_gallery = "SELECT image_filename, caption FROM gallery_images ORDER BY RAND() LIMIT 4";
            $result_gallery = $conn->query($sql_gallery);

            if ($result_gallery && $result_gallery->num_rows > 0) {
                while($row = $result_gallery->fetch_assoc()) {
                    // We can reuse the .gallery-item style
                    echo '<a href="assets/images/gallery/' . htmlspecialchars($row['image_filename']) . '" class="gallery-item" data-caption="' . htmlspecialchars($row['caption']) . '">';
                    echo '    <img src="assets/images/gallery/' . htmlspecialchars($row['image_filename']) . '" alt="' . htmlspecialchars($row['caption']) . '">';
                    echo '    <div class="overlay"><i class="fas fa-search-plus"></i></div>';
                    echo '</a>';
                }
            }
            ?>
        </div>
        <div class="section-cta">
            <a href="gallery.php" class="btn btn-primary">View Full Gallery</a>
        </div>
    </div>
</section>


<?php 
$conn->close();
require_once 'includes/footer.php'; 
?>