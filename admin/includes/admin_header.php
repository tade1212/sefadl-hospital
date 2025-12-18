<?php
session_start();

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION["admin_loggedin"]) || $_SESSION["admin_loggedin"] !== true) {
    header("location: index.php");
    exit;
}

// Include the database connection for the notification queries
require_once '../includes/db_connect.php';

// Count unread messages
$result_msg = $conn->query("SELECT COUNT(id) AS unread_count FROM contact_messages WHERE is_read = 0");
$unread_msg_count = $result_msg ? $result_msg->fetch_assoc()['unread_count'] : 0;

// Count unread appointments
$result_appt = $conn->query("SELECT COUNT(id) AS unread_count FROM appointments WHERE is_read = 0");
$unread_appt_count = $result_appt ? $result_appt->fetch_assoc()['unread_count'] : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Sefadl Hospital</title>
    
    <!-- Corrected Absolute Paths for CSS -->
    <link rel="stylesheet" href="./assets/admin_style.css">
    <link rel="stylesheet" href="./assets/responsive.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Montserrat:wght@600;700&display=swap" rel="stylesheet">
    
    <!-- Corrected Absolute Path for JavaScript -->
    <script src="./assets/js/admin_script.js" defer></script>
</head>
<body>

<div class="admin-wrapper">
    <aside class="sidebar">
        <div class="sidebar-header">
            <a href="../index.php" target="_blank" title="View Public Site">
                <img src="../assets/images/sefadl.jpg" alt="Logo" class="sidebar-logo">
            </a>
            <h3><a href="dashboard.php">Admin Panel</a></h3>
        </div>
        <ul class="sidebar-nav">
            <li class="nav-item"><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>
            <li class="nav-item">
                <a href="appointments.php" style="position: relative;">
                    <i class="fas fa-calendar-check"></i> 
                    <span>Appointments</span>
                    <?php if ($unread_appt_count > 0): ?>
                        <!-- Inline CSS for the badge included as per your setup -->
                        <span class="notification-badge" style="position: absolute; top: 12px; right: 15px; background-color: #dc3545; color: #fff; font-size: 0.75rem; font-weight: 700; height: 20px; width: 20px; border-radius: 50%; display: flex; justify-content: center; align-items: center; line-height: 1; box-shadow: 0 0 5px rgba(0,0,0,0.3);">
                            <?php echo $unread_appt_count; ?>
                        </span>
                    <?php endif; ?>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="messages.php" style="position: relative;">
                    <i class="fas fa-envelope-open-text"></i> 
                    <span>Messages</span>
                    <?php if ($unread_msg_count > 0): ?>
                        <span class="notification-badge" style="position: absolute; top: 12px; right: 15px; background-color: #dc3545; color: #fff; font-size: 0.75rem; font-weight: 700; height: 20px; width: 20px; border-radius: 50%; display: flex; justify-content: center; align-items: center; line-height: 1; box-shadow: 0 0 5px rgba(0,0,0,0.3);">
                            <?php echo $unread_msg_count; ?>
                        </span>
                    <?php endif; ?>
                </a>
            </li>
            
            <li class="nav-item"><a href="manage_services.php"><i class="fas fa-briefcase-medical"></i> <span>Services</span></a></li>
            <li class="nav-item"><a href="manage_doctors.php"><i class="fas fa-user-md"></i> <span>Doctors</span></a></li>
            <li class="nav-item"><a href="manage_news.php"><i class="fas fa-newspaper"></i> <span>News</span></a></li>
            <li class="nav-item"><a href="manage_gallery.php"><i class="fas fa-images"></i> <span>Gallery</span></a></li>
            <a href="changePassword.php" class="change-password-btn"><i class="fas fa-key"></i> Change Password</a>
            
        </ul>
    </aside>

    <!-- The Page Overlay for mobile menu (CRITICAL for JS compatibility) -->
    <div class="page-overlay" id="page-overlay"></div>
e
    <div class="main-content">
        <header class="top-header">
            <button class="mobile-menu-btn" id="mobile-menu-btn">
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
            </button>
            <div class="welcome-message">
                Welcome, <strong><?php echo htmlspecialchars($_SESSION["admin_username"]); ?></strong>
            </div>
            <div class="header-right">
            <a href="includes/logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </header>

        <main class="content-area">