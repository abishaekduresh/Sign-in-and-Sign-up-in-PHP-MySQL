<?php

session_start();
require_once "secure/api/v1/Components.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign In Form</title>
  <!-- Bootstrap CSS -->
  <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <div class="card my-5">

          <form class="card-body p-lg-5" id="signInForm">
            <!-- CSRF token -->
            <input type="hidden" id="csrf_token" value="<?= generateCSRFToken(); ?>">
            <div class="text-center">
              <img src="https://cdn.pixabay.com/photo/2016/03/31/19/56/avatar-1295397__340.png" class="img-fluid profile-image-pic img-thumbnail rounded-circle my-3"
                width="200px" alt="profile">
            </div>

            <div class="mb-3">
              <input type="text" class="form-control" id="username" aria-describedby="passwordHelp"
                placeholder="User Name">
            </div>
            <div class="mb-3">
              <input type="password" class="form-control" id="password" placeholder="password">
            </div>
            <div class="text-center"><button type="submit" class="btn btn-primary px-5 mb-5 w-100">Login</button></div>
            <div id="passwordHelp" class="form-text text-center mb-5 text-dark">Not
              Registered? <a href="SignUp.php" class="text-dark fw-bold"> Create an
                Account</a>
            </div>
          </form>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-body">
                <b><span id="response"></span> : <span id="countdown"></span></b>
              </div>
            </div>
          </div>
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
    $("#signInForm").submit(function(event){
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
    };

    $.ajax({
        type: "POST",
        url: "secure/api/v1/SignIn.php",
        data: JSON.stringify(formData),
        contentType: "application/json",
        success: function(response) {
            $("#response").html(response.message);
            openModal();
            document.getElementById("signInForm").reset();
            if(response.code==01){
              var countdown = 3;
              $("#countdown").text(countdown);
              var interval = setInterval(function() {
                  countdown--;
                  $("#countdown").text(countdown);
                  if (countdown == 0) {
                      clearInterval(interval);
                      window.location.href = 'dashboard.php';
                  }
              }, 1000);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', status);
            alert(status);
        }
    });
}

</script>
</body>
</html>
