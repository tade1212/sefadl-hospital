<?php
// Start the session ONCE at the very beginning of the script.
session_start();

// If the user is already logged in, redirect them to the dashboard.
if (isset($_SESSION["admin_loggedin"]) && $_SESSION["admin_loggedin"] === true) {
    header("location: dashboard.php");
    exit;
}

// Include the database connection file.
require_once '../includes/db_connect.php';

$username = $password = "";
$error_message = "";

// Process form data when the form is submitted.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate username.
    if (empty(trim($_POST["username"]))) {
        $error_message = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Validate password.
    if (empty(trim($_POST["password"]))) {
        $error_message = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Proceed if there are no validation errors.
    if (empty($error_message)) {
        $sql = "SELECT id, username, password_hash FROM admin_users WHERE username = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $username);
            
            if ($stmt->execute()) {
                $stmt->store_result();
                
                // Check if username exists.
                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($id, $username, $hashed_password);
                    if ($stmt->fetch()) {
                        // Use password_verify() to check if the entered password matches the stored hash.
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct.
                            // Session is already started, so we just set the variables.
                            
                            $_SESSION["admin_loggedin"] = true;
                            $_SESSION["admin_id"] = $id;
                            $_SESSION["admin_username"] = $username;
                            
                            // Redirect user to the dashboard.
                            header("location: dashboard.php");
                            exit();
                        } else {
                            // Password is not valid.
                            $error_message = "The password you entered was not valid.";
                        }
                    }
                } else {
                    // Username doesn't exist.
                    $error_message = "No account found with that username.";
                }
            } else {
                $error_message = "Oops! Something went wrong. Please try again later.";
            }
            $stmt->close();
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Sefadl Hospital</title>
    <link rel="stylesheet" href="assets/admin_style.css">
    <link rel="stylesheet" href="assets/responsive.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Montserrat:wght@600;700&display=swap" rel="stylesheet">
    
    <!-- Link to the main JS file for the password toggle feature -->
    <!-- <script src="./assets/js/main.js" defer></script> -->
    <script src="assets/js/admin_script.js" defer></script>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-container">
            <img src="../assets/images/sefadl.jpg" alt="Sefadl Hospital Logo" class="login-logo">
            <h2>Admin Panel Login</h2>
            
            <?php 
            if(!empty($error_message)){
                echo '<div class="alert-danger">' . $error_message . '</div>';
            }        
            ?>
            
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>">
                </div>    
                <div class="form-group">
                    <label>Password</label>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="password-field">
                        <span class="toggle-password" id="toggle-password">👁️</span>
                    </div>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn-login" value="Login">
                </div>
            </form>
        </div>
    </div>
</body>
</html>