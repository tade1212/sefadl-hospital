<?php 
require_once 'includes/header.php'; 
require_once 'includes/db_connect.php';

// 1. Check if an ID is present and valid in the URL.
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $article_id = $_GET['id'];

    // 2. Prepare and execute a query to fetch the specific article's details.
    $stmt = $conn->prepare("SELECT title, content, author_name, publish_date, featured_image_filename FROM news_articles WHERE id = ?");
    $stmt->bind_param("i", $article_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // 3. Fetch the article data.
    if ($result->num_rows === 1) {
        $article = $result->fetch_assoc();
    } else {
        // No article was found with that ID.
        $article = null;
    }
    $stmt->close();
} else {
    // No ID was provided in the URL.
    $article = null;
}
$conn->close();
?>

<div class="container article-container">
    <?php if ($article): ?>
        <?php 
            // Format the date for display.
            $formatted_date = date("F j, Y", strtotime($article['publish_date']));
        ?>
        <!-- This section displays if an article was successfully found -->
        <article class="news-article">
            <header class="article-header">
                <h1><?php echo htmlspecialchars($article['title']); ?></h1>
                <p class="meta">
                    Published by <strong><?php echo htmlspecialchars($article['author_name']); ?></strong> 
                    on <?php echo $formatted_date; ?>
                </p>
            </header>

            <div class="article-image-container">
                <img src="assets/images/news/<?php echo htmlspecialchars($article['featured_image_filename']); ?>" alt="<?php echo htmlspecialchars($article['title']); ?>">
            </div>

            <div class="article-content">
                <?php 
                    // Use nl2br() to convert newline characters from the database's TEXT field 
                    // into proper <br> tags for HTML paragraph breaks.
                    echo nl2br(htmlspecialchars($article['content'])); 
                ?>
            </div>

            <footer class="article-footer">
                <a href="news.php" class="btn btn-secondary">← Back to News</a>
            </footer>
        </article>

    <?php else: ?>
        <!-- This section displays if no article was found -->
        <div class="text-center" style="padding: 60px 0;">
            <h2>Article Not Found</h2>
            <p>We're sorry, but the article you are looking for does not exist.</p>
            <a href="news.php" class="btn btn-primary">View All News</a>
        </div>
    <?php endif; ?>
</div>

<?php 
require_once 'includes/footer.php'; 
?>