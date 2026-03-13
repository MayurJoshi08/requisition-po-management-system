<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get the year from session, default to 25-26
$year = $_SESSION['dcyear'] ?? '25-26';

// Set database credentials
$DB_SERVER = '127.0.0.1';
$DB_USER   = 'root';
$DB_PASS   = ''; // LAN user password

if ($year == '25-26') {
    $DB_NAME = 'Reception';
} else {
    $DB_NAME = 'reception' . $year;
}

// Connect to database
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);

// Check connection
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
