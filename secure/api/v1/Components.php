<?php

// Function to generate a CSRF token
function generateCSRFToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Function to validate CSRF token
function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Function to generate a unique token
function generateToken() {
    return bin2hex(random_bytes(32));
}

// Validate input
function validateInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function generateRandomValue() {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789@$%^&';
    $randomValue = '';
    $length = strlen($characters);
    for ($i = 0; $i < 5; $i++) {
        $randomIndex = rand(0, $length - 1);
        $randomValue .= $characters[$randomIndex];
    }
    return $randomValue;
}

?>