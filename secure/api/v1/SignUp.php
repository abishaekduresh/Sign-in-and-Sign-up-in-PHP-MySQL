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
$confirm_password = validateInput($data['confirm_password']);
$email = validateInput($data['email']);

if(!empty($username) && !empty($password) && !empty($email)){

    if (!empty($_SESSION['csrf_token']) && $csrf_token === $_SESSION['csrf_token']) {
        // Check if passwords match
        if ($password === $confirm_password) {
    
            $hashed_password = hash('sha512', $password);
    
            // Prepare and bind
            $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $hashed_password, $email);
    
            // Execute SQL
            if ($stmt->execute() === TRUE) {
    
                $data = array(
                    "status" => "success",
                    "message" => "Data successfully submitted",
                    "code" => "01",
                    "data" => array(
                        "username" => $username,
                        "email" => $email
                    )
                );
                
                echo json_encode($data);
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
                "message" => "Password Mismatch",
                "code" => "03"
            );    
            
            echo json_encode($data);
        }
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
