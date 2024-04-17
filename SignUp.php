<?php
session_start();
require_once "secure/api/v1/Components.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up Form</title>
  <!-- Bootstrap CSS -->
  <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <div class="card my-5">
          <form class="card-body p-lg-5" id="signUpForm">
            <!-- CSRF token -->
            <input type="hidden" id="csrf_token" value="<?= generateCSRFToken(); ?>">
            <div class="text-center">
              <img src="https://cdn.pixabay.com/photo/2016/03/31/19/56/avatar-1295397__340.png" class="img-fluid profile-image-pic img-thumbnail rounded-circle my-3"
                width="200px" alt="profile">
            </div>
            <div class="mb-3">
              <input type="text" class="form-control" id="username" aria-describedby="passwordHelp" placeholder="User Name" required>
            </div>
            <div class="mb-3">
              <input type="email" class="form-control" id="email" placeholder="Email" required>
            </div>
            <div class="mb-3">
              <input type="password" class="form-control" id="password" placeholder="Password" required>
            </div>
            <div class="mb-3">
              <input type="password" class="form-control" id="confirm_password" placeholder="Confirm Password" required>
            </div><p id="error_message" style="color: red;"></p>
            <div class="text-center">
              <button type="submit" id="submitBtn" class="btn btn-primary px-5 mb-5 w-100">Sign Up</button>
            </div>
            <div id="passwordHelp" class="form-text text-center mb-5 text-dark">Registered <a href="SignIn.php" class="text-dark fw-bold"> Sign In</a></div>
          </form>
        </div>
      </div>
    </div>
  </div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <b><span id="response"></span></b>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function(){
    $("#signUpForm").submit(function(event){
        event.preventDefault();
        submitForm();
    });
});

function openModal() {
        var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
        myModal.show();
}

function submitForm() {
    var formData = {
        csrf_token: $("#csrf_token").val().trim(),
        username: $("#username").val().trim(),
        password: $("#password").val().trim(),
        confirm_password: $("#confirm_password").val().trim(),
        email: $("#email").val().trim()
    };

    $.ajax({
        type: "POST",
        url: "secure/api/v1/SignUp.php",
        data: JSON.stringify(formData),
        contentType: "application/json",
        success: function(response) {
            $("#response").html(response.message); // Display response message
            openModal();
            // alert(response.message);
            document.getElementById("signUpForm").reset();
        },
        error: function(xhr, status, error) {
            console.error('Error:', status);
            alert(status);
        }
    });
}

function checkPasswordMatch() {
        var password = document.getElementById("password").value;
        var confirm_password = document.getElementById("confirm_password").value;

        // Check if passwords match
        if (password !== confirm_password) {
            // Display error message
            document.getElementById("error_message").textContent = "Passwords do not match";
        } else {
            // Clear error message if passwords match
            document.getElementById("error_message").textContent = "";
        }
    }

    // Add event listeners to password and confirm password fields
    document.getElementById("password").addEventListener("input", checkPasswordMatch);
    document.getElementById("confirm_password").addEventListener("input", checkPasswordMatch);

</script>
</body>
</html>
