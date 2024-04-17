<?php
require_once("../../DBConfig.php");
require_once("Components.php");

// Retrieve JSON data
$data = json_decode(file_get_contents('php://input'), true);

// Set content type header to application/json
header('Content-Type: application/json');

// Extract data
$csrf_token = validateInput($data['csrf_token']);
$username = validateInput($data['username']);
$password = validateInput($data['password']);

if(!empty($username) && !empty($password)){

    if (!empty($_SESSION['csrf_token']) && $csrf_token === $_SESSION['csrf_token']) {
    
        $hashed_password = hash('sha512', $password);

        // Prepare and bind
        $stmt = $conn->prepare("SELECT username, password FROM users WHERE username=? AND password=?");
        $stmt->bind_param("ss", $username, $hashed_password);

        // Execute SQL
        if ($stmt->execute() === TRUE) {

            // If there's a match, redirect to another page
            if ($stmt->fetch()) {

                // If no match found, show error message
                $data = array(
                    "status" => "success",
                    "message" => "Login Successful",
                    "code" => "01"
                );
                $_SESSION['username'] = $username;
                
                echo json_encode($data);

            } else {
                // If no match found, show error message
                $data = array(
                    "status" => "failed",
                    "message" => "Invalid username or password",
                    "code" => "03"
                );    
                echo json_encode($data);
            }

        } else {

            $data = array(
                "status" => "failed",
                "message" => "Error: " . $conn->error,
                "code" => "02"
            );    
            
            echo json_encode($data);
        }

        // Close statement
        $stmt->close();

    } else {
        
        $data = array(
            "status" => "failed",
            "message" => "CSRF Token Invalid",
            "code" => "04"
        );    
        
        echo json_encode($data);
    }

} else {
        
    $data = array(
        "status" => "failed",
        "message" => "Some Fields are Empty",
        "code" => "05"
    );    
    
    echo json_encode($data);
}


// Close connection
$conn->close();
?>
