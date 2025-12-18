<?php 
require_once 'includes/header.php'; 
?>

<!-- Page Title Banner -->
<section class="page-banner" style="background-image: url('assets/images/services/ser1.jpg');">
    <div class="container">
        <h1>Hospital News & Updates</h1>
        <p>Stay informed with the latest health tips and news from our team.</p>
    </div>
</section>

<!-- Main News Listing Section -->
<section class="news-page-section">
    <div class="container">
        <div class="news-grid">
            <?php
            // 1. Include the database connection.
            require_once 'includes/db_connect.php';

            // 2. Define the SQL query to fetch all articles, newest first.
            $sql = "SELECT id, title, excerpt, author_name, publish_date, featured_image_filename FROM news_articles ORDER BY publish_date DESC";
            
            // 3. Execute the query.
            $result = $conn->query($sql);

            // 4. Check for results.
            if ($result && $result->num_rows > 0) {
                // 5. Loop through each article.
                while($row = $result->fetch_assoc()) {
                    // Format the date for display
                    $formatted_date = date("F j, Y", strtotime($row['publish_date']));

                    // Generate the HTML for each news card.
                    echo '<div class="news-card">';
                    echo '    <a href="news-detail.php?id=' . $row['id'] . '" class="news-card-image-link">';
                    echo '        <img src="assets/images/news/' . htmlspecialchars($row["featured_image_filename"]) . '" alt="' . htmlspecialchars($row["title"]) . '">';
                    echo '    </a>';
                    echo '    <div class="news-card-content">';
                    echo '        <p class="meta">' . htmlspecialchars($row["author_name"]) . ' &bull; ' . $formatted_date . '</p>';
                    echo '        <h3><a href="news-detail.php?id=' . $row['id'] . '">' . htmlspecialchars($row["title"]) . '</a></h3>';
                    echo '        <p class="excerpt">' . htmlspecialchars($row["excerpt"]) . '</p>';
                    echo '        <a href="news_detail.php?id=' . $row['id'] . '" class="btn-learn-more">Read More</a>';
                    echo '    </div>';
                    echo '</div>';
                }
            } else {
                echo "<p>There are currently no news articles. Please check back soon.</p>";
            }

            // 6. Close the connection.
            $conn->close();
            ?>
        </div>
    </div>
</section>

<?php 
require_once 'includes/footer.php'; 
?>