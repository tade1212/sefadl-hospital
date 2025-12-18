<?php 
require_once 'includes/admin_header.php'; 
require_once '../includes/db_connect.php';

$error_message = '';
$success_message = '';

// Process the form when it is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Basic validation
    if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
        $error_message = "Please fill in all fields.";
    } elseif ($new_password !== $confirm_password) {
        $error_message = "New password and confirm password do not match.";
    } elseif (strlen($new_password) < 8) {
        $error_message = "New password must be at least 8 characters long.";
    } else {
        // Validation passed, now verify the old password
        $admin_id = $_SESSION['admin_id'];
        $sql = "SELECT password_hash FROM admin_users WHERE id = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $admin_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
                // Verify the old password against the stored hash
                if (password_verify($old_password, $user['password_hash'])) {
                    // Old password is correct, now hash the new password
                    $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                    // Update the password in the database
                    $update_sql = "UPDATE admin_users SET password_hash = ? WHERE id = ?";
                    if ($update_stmt = $conn->prepare($update_sql)) {
                        $update_stmt->bind_param("si", $new_password_hash, $admin_id);
                        if ($update_stmt->execute()) {
                            $success_message = "Password changed successfully!";
                        } else {
                            $error_message = "Oops! Something went wrong. Please try again.";
                        }
                        $update_stmt->close();
                    }
                } else {
                    $error_message = "The old password you entered is incorrect.";
                }
            }
            $stmt->close();
        }
    }
}
?>

<!-- Main container with styles -->
<div style="background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">

    <!-- Page Header -->
    <div style="margin-bottom: 30px;margin-top:40px; padding-bottom: 20px; border-bottom: 1px solid #eee;">
        <h1 style=" background-color:lightblue;padding:10px 15px 10px 30px;border-radius:18px;text-align:center;font-family: 'Montserrat', sans-serif; margin: 0;">Change Password</h1>
        <p style="color: #666; margin: 5px 0 0 0;">Update your administrator password here.</p>
    </div>

    <!-- Form container -->
    <div style="max-width: 600px; margin: 0 auto;">

        <?php if (!empty($error_message)): ?>
            <div style="padding: 15px; margin-bottom: 20px; border-radius: 5px; color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; text-align: center;">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($success_message)): ?>
            <div style="padding: 15px; margin-bottom: 20px; border-radius: 5px; color: #155724; background-color: #d4edda; border-color: #c3e6cb; text-align: center;">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            
            <div style="margin-bottom: 25px;">
                <label for="old_password" style="display: block; margin-bottom: 8px; font-weight: 700; color: #555;">Old Password</label>
                <input type="password" id="old_password" name="old_password" required style="width: 100%; padding: 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 1rem;">
            </div>

            <div style="margin-bottom: 25px;">
                <label for="new_password" style="display: block; margin-bottom: 8px; font-weight: 700; color: #555;">New Password</label>
                <input type="password" id="new_password" name="new_password" required style="width: 100%; padding: 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 1rem;">
                <small style="display: block; color: #777; margin-top: 8px;">Must be at least 8 characters long.</small>
            </div>

            <div style="margin-bottom: 25px;">
                <label for="confirm_password" style="display: block; margin-bottom: 8px; font-weight: 700; color: #555;">Confirm New Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required style="width: 100%; padding: 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 1rem;">
            </div>
            
            <div style="margin-bottom: 25px;">
                <button type="submit" style="display: inline-block; cursor: pointer; border: none; padding: 12px 30px; font-size: 1.1rem; background-color: #00A0B0; color: #fff; border-radius: 5px; font-weight: 700;">Update Password</button>
            </div>

        </form>
    </div>
</div>

<?php 
$conn->close();
require_once 'includes/admin_footer.php'; 
?>