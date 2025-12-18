<?php 
require_once 'includes/header.php'; 
require_once 'includes/db_connect.php';

// ነቲ ሓበሬታ ናይቲ ዝተመረጸ ኣገልግሎት ካብ ዳታቤዝ ምምጻእ
$service = null;
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $service_id = $_GET['id'];

    // ነቲ ስም፡ விளக்கம்፡ ከምኡውን ስም-ፋይል ናይ ስእሊ ጥራይ ንውሰድ
    $stmt = $conn->prepare("SELECT service_name, description, image_filename FROM services WHERE id = ?");
    $stmt->bind_param("i", $service_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $service = $result->fetch_assoc();
    }
    $stmt->close();
}
$conn->close();
?>

<!-- እዚ ገጽ ዝረአ፡ እቲ ኣገልግሎት ኣብ ዳታቤዝ እንተተረኺቡ ጥራይ እዩ -->
<?php if ($service): ?>

<!-- እቲ ቀንዲ ትሕዝቶ ናይቲ ገጽ -->
<section class="service-detail-simple-section">
    <div class="container">
        <!-- እቲ ርእሲ ናይቲ ኣገልግሎት -->
        <div class="section-title">
            <h1><?php echo htmlspecialchars($service['service_name']); ?></h1>
        </div>

        <!-- እቲ ጎንበጎን ዝኾነ ቅርጺ (layout) -->
        <div class="detail-simple-layout">
            
            <!-- ዓምዲ 1: እቲ ስእሊ -->
            <div class="detail-image-container">
                <img src="assets/images/services/<?php echo htmlspecialchars($service['image_filename']); ?>" alt="<?php echo htmlspecialchars($service['service_name']); ?>">
            </div>

            <!-- ዓምዲ 2: እቲ விளக்கம் -->
            <div class="detail-content-container">
                <h2>Description</h2>
                <p><?php echo nl2br(htmlspecialchars($service['description'])); ?></p>
            </div>

        </div>
    </div>
</section>

<?php else: ?>
    <!-- እቲ ኣገልግሎት እንተዘይተረኺቡ ዝረአ መልእኽቲ -->
    <section class="detail-page-section text-center">
        <div class="container">
            <h2>Service Not Found</h2>
            <p>We're sorry, but the service you are looking for does not exist.</p>
            <a href="services.php" class="btn btn-primary">View All Services</a>
        </div>
    </section>
<?php endif; ?>

<?php 
require_once 'includes/footer.php'; 
?>