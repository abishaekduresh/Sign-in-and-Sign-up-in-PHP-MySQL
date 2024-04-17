<?php
session_start();

// Database connection configuration
$db_host = 'localhost:3310';
$db_username = 'root';
$db_password = 'root';
$db_name = 'signin-signup';


// Create connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    // echo "Connected successfully";
}
?>