<?php

// Include database connection file
include_once("../../DBConfig.php");

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Decode JSON data received from client
    $formData = json_decode(file_get_contents("php://input"), true);

    // Extract data from JSON
    $name = $formData['name'];
    $email = $formData['email'];

    // Perform basic validation
    if (empty($name) || empty($email)) {
        http_response_code(400);
        echo "Please fill in all fields.";
        exit;
    }

    // Sanitize input data
    $name = htmlspecialchars($name);
    $email = htmlspecialchars($email);

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $email);

    // Execute the statement
    if ($stmt->execute()) {
        // Data inserted successfully
        echo "Data inserted successfully.";
    } else {
        // Error occurred
        http_response_code(500);
        echo "Error inserting data into database.";
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // Method not allowed
    http_response_code(405);
    echo "Method Not Allowed";
}
?>
