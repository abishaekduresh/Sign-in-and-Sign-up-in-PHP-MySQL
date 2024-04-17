<?php
session_start(); // Start the session

// Check if username session variable is empty
if(empty($_SESSION['username'])){
    header('Location: SignIn.php'); // Redirect to SignIn.php if username is empty
    exit(); // Stop further execution
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
</head>
<body>
    <h1>Hi, <?php echo $_SESSION['username']; ?></h1>
    <a href="secure/api/v1/logout.php">Logout</a>
</body>
</html>
