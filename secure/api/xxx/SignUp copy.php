<?php

// Include database connection file
require_once("../../DBConfig.php");

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Decode JSON data received from client
    $data = json_decode(file_get_contents("php://input"), true);

    // Check if required fields are provided
    if (!isset($data['username']) || !isset($data['password'])) {
        http_response_code(400);
        echo "Please provide both username and password.";
        exit;
    }

    // Extract data from JSON and sanitize
    $username = trim(htmlspecialchars($data['username']));
    $password = trim(htmlspecialchars($data['password']));

    // Perform basic validation
    if (empty($username) || empty($password)) {
        http_response_code(400);
        echo "Please fill in all fields.";
        exit;
    }

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");

    if (!$stmt) {
        http_response_code(500);
        echo "Error preparing statement: " . $conn->error;
        exit;
    }

    $stmt->bind_param("ss", $username, $password);

    // Execute the statement
    if ($stmt->execute()) {
        // Data inserted successfully
        echo "Data inserted successfully.";
    } else {
        // Error occurred
        http_response_code(500);
        echo "Error inserting data into database: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
} else {
    // Method not allowed
    http_response_code(405);
    echo "Method Not Allowed";
}

// Close database connection
$conn->close();
?>
