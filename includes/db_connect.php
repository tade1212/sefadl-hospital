<?php
/*
 * Sefadl Hospital - Database Connection File
 * Using your preferred connection format.
 */

// --- Database Connection Settings ---
$servername = "localhost";
$username   = "root";     // Your MySQL username
$password   = "";         // Your MySQL password
$dbname     = "sefadl_db"; // The database for THIS project
$db_port    = 3307;       // Your specified MySQL port

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $db_port);

// Check connection
if ($conn->connect_error) {
    // If the connection fails, stop the script and display the error.
    die("Connection failed: " . $conn->connect_error);
}

// Optional but recommended: Set character set for proper data handling
$conn->set_charset("utf8mb4");

// This file now creates the connection and stores it in the $conn variable.
// There is no success message here, as it would show up on every page.
?>