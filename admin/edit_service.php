<?php 
require_once 'includes/admin_header.php'; 
require_once '../includes/db_connect.php';

// Initialize variables
$service_id = null;
$service_name = '';
$description = '';
$image_filename = '';
$page_title = 'Add New Service';
$form_action = 'service_actions.php?action=add';

// Check if an ID is passed for editing, then fetch existing data
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $service_id = $_GET['id'];
    $page_title = 'Edit Service';
    $form_action = 'service_actions.php?action=update&id=' . $service_id;

    $stmt = $conn->prepare("SELECT service_name, description, image_filename FROM services WHERE id = ?");
    $stmt->bind_param("i", $service_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $service = $result->fetch_assoc();
        $service_name = $service['service_name'];
        $description = $service['description'];
        $image_filename = $service['image_filename'];
    }
    $stmt->close();
}
?>

<!-- The main white container for the page -->
<div style="background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">

    <!-- The header section inside the white box -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid #eee;">
        <h1 style="font-family: 'Montserrat', sans-serif; margin: 0;"><?php echo $page_title; ?></h1>
        <a href="manage_services.php" style="background-color: #231F20; color: #fff; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: 700;">← Back to Services</a>
    </div>

    <!-- The form container, centered with a max-width -->
    <div style="max-width: 800px; margin: 0 auto;">
        <form action="<?php echo $form_action; ?>" method="POST" enctype="multipart/form-data">
            
            <div style="margin-bottom: 25px;">
                <label for="service_name" style="display: block; margin-bottom: 8px; font-weight: 700; color: #555;">Service Name</label>
                <input type="text" id="service_name" name="service_name" value="<?php echo htmlspecialchars($service_name); ?>" required style="width: 100%; padding: 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 1rem;">
            </div>

            <div style="margin-bottom: 25px;">
                <label for="description" style="display: block; margin-bottom: 8px; font-weight: 700; color: #555;">Description</label>
                <textarea id="description" name="description" rows="10" required style="width: 100%; padding: 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 1rem;"><?php echo htmlspecialchars($description); ?></textarea>
            </div>

            <div style="margin-bottom: 25px;">
                <label for="image" style="display: block; margin-bottom: 8px; font-weight: 700; color: #555;">Service Image</label>
                <input type="file" id="image" name="image" accept="image/jpeg, image/png, image/gif">
                <small style="display: block; color: #777; margin-top: 8px;">Upload a new image to replace the current one. Leave blank to keep the existing image.</small>
                
                <?php if ($image_filename): ?>
                    <div style="margin-top: 15px;">
                        <p style="font-weight: 700; margin-bottom: 10px; color: #333;">Current Image:</p>
                        <img src="../assets/images/services/<?php echo htmlspecialchars($image_filename); ?>" alt="Current Image" style="max-width: 200px; height: auto; border: 3px solid #e9e9e9; border-radius: 5px;">
                    </div>
                <?php endif; ?>
            </div>

            <div style="margin-bottom: 25px;">
                <button type="submit" style="display: inline-block; cursor: pointer; border: none; padding: 12px 30px; font-size: 1.1rem; background-color: #00A0B0; color: #fff; border-radius: 5px; font-weight: 700;">Save Service</button>
            </div>

        </form>
    </div>
</div>

<?php 
$conn->close();
require_once 'includes/admin_footer.php'; 
?>