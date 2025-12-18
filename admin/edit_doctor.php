<?php 
require_once 'includes/admin_header.php'; 
require_once '../includes/db_connect.php';

// Initialize variables
$doctor_id = null;
$full_name = '';
$specialty = '';
$bio = '';
$phone_number = '';
$email_address = '';
$photo_filename = '';
$page_title = 'Add New Doctor';
$form_action = 'doctor_actions.php?action=add';

// Check if an ID is passed for editing, then fetch existing data
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $doctor_id = $_GET['id'];
    $page_title = 'Edit Doctor Profile';
    $form_action = 'doctor_actions.php?action=update&id=' . $doctor_id;

    $stmt = $conn->prepare("SELECT full_name, specialty, bio, phone_number, email_address, photo_filename FROM doctors WHERE id = ?");
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $doctor = $result->fetch_assoc();
        $full_name = $doctor['full_name'];
        $specialty = $doctor['specialty'];
        $bio = $doctor['bio'];
        $phone_number = $doctor['phone_number'];
        $email_address = $doctor['email_address'];
        $photo_filename = $doctor['photo_filename'];
    }
    $stmt->close();
}
?>

<!-- The main white container for the page -->
<div style="background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">

    <!-- The header section inside the white box -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid #eee;">
        <h1 style="font-family: 'Montserrat', sans-serif; margin: 0;"><?php echo $page_title; ?></h1>
        <a href="manage_doctors.php" style="background-color: #231F20; color: #fff; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: 700;">← Back to Doctors</a>
    </div>

    <!-- The form container, centered with a max-width -->
    <div style="max-width: 800px; margin: 0 auto;">
        <form action="<?php echo $form_action; ?>" method="POST" enctype="multipart/form-data">
            
            <div style="margin-bottom: 25px;">
                <label for="full_name" style="display: block; margin-bottom: 8px; font-weight: 700; color: #555;">Full Name (e.g., Dr. John Doe)</label>
                <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($full_name); ?>" required style="width: 100%; padding: 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 1rem;">
            </div>
            
            <div style="margin-bottom: 25px;">
                <label for="specialty" style="display: block; margin-bottom: 8px; font-weight: 700; color: #555;">Specialty (e.g., Cardiologist)</label>
                <input type="text" id="specialty" name="specialty" value="<?php echo htmlspecialchars($specialty); ?>" required style="width: 100%; padding: 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 1rem;">
            </div>

            <div style="margin-bottom: 25px;">
                <label for="phone_number" style="display: block; margin-bottom: 8px; font-weight: 700; color: #555;">Phone Number</label>
                <input type="tel" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($phone_number); ?>" style="width: 100%; padding: 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 1rem;">
            </div>

            <div style="margin-bottom: 25px;">
                <label for="email_address" style="display: block; margin-bottom: 8px; font-weight: 700; color: #555;">Email Address</label>
                <input type="email" id="email_address" name="email_address" value="<?php echo htmlspecialchars($email_address); ?>" style="width: 100%; padding: 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 1rem;">
            </div>

            <div style="margin-bottom: 25px;">
                <label for="bio" style="display: block; margin-bottom: 8px; font-weight: 700; color: #555;">Biography</label>
                <textarea id="bio" name="bio" rows="8" required style="width: 100%; padding: 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 1rem;"><?php echo htmlspecialchars($bio); ?></textarea>
            </div>

            <div style="margin-bottom: 25px;">
                <label for="photo" style="display: block; margin-bottom: 8px; font-weight: 700; color: #555;">Doctor's Photo</label>
                <input type="file" id="photo" name="photo" accept="image/jpeg, image/png, image/gif">
                <small style="display: block; color: #777; margin-top: 8px;">Upload a new photo to replace the current one. Leave blank to keep the existing photo.</small>
                
                <?php if ($photo_filename): ?>
                    <div style="margin-top: 15px;">
                        <p style="font-weight: 700; margin-bottom: 10px; color: #333;">Current Photo:</p>
                        <img src="../assets/images/doctors/<?php echo htmlspecialchars($photo_filename); ?>" alt="Current Photo" style="max-width: 200px; height: auto; border: 3px solid #e9e9e9; border-radius: 5px;">
                    </div>
                <?php endif; ?>
            </div>

            <div style="margin-bottom: 25px;">
                <button type="submit" style="display: inline-block; cursor: pointer; border: none; padding: 12px 30px; font-size: 1.1rem; background-color: #00A0B0; color: #fff; border-radius: 5px; font-weight: 700;">Save Doctor Profile</button>
            </div>

        </form>
    </div>
</div>

<?php 
$conn->close();
require_once 'includes/admin_footer.php'; 
?>