<?php
include './connections/connections.php';

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (isset($_SESSION['user_id'])) {
  header("Location: /pendragonsystem2027/views/dashboard.php");
  exit();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="icon" type="image/png" href="/pendragonsystem2027/views/ico.jpg">

  <title><?php echo $page_title ?? 'Pendragon System Login'; ?></title>

  <link rel="stylesheet" href="assets/css/tabler.min.css">
  <link rel="stylesheet" href="assets/css/tabler-icons.min.css">
  <link rel="stylesheet" href="assets/css/login.css">
  <link rel="stylesheet" href="assets/css/toastr.min.css">

</head>

<body>

  <div class="page page-center">
    <div class="container container-tight py-4">

      <div class="card card-md login-card mx-auto card-gradient card-gradient-ocean">

        <!-- CARD HEADER / LOGO -->
        <div class="login-card-header text-center">
          <a href="index.php">
            <span class="brand-logo-login">
              <img src="./assets/img/logo.svg" alt="Pendragon Logo">
            </span>
          </a>
        </div>

        <!-- CARD BODY -->
        <div class="card-body">

          <h2 class="h2 text-center mb-2">Let's Get Started!</h2>

          <p class="text-secondary text-center mb-4">
            Sign in to your account to continue.
          </p>

          <form id="loginForm">

            <!-- Username / Email -->
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="floating-name" name="full_name" placeholder="Jane Doe"
                autocomplete="username" required>

              <label for="floating-name">Username / Email</label>
            </div>

            <!-- Password -->
            <div class="form-floating mb-3 position-relative">

              <input type="password" class="form-control password-input" id="floating-password" name="password"
                placeholder="Password" autocomplete="current-password" required>

              <label for="floating-password">Password</label>

              <button type="button" class="password-toggle" id="togglePassword" aria-label="Show password"
                aria-pressed="false">

                <i class="ti ti-eye" id="passwordIcon"></i>

              </button>
            </div>

            <!-- LOGIN BUTTON -->
            <div class="form-footer">
              <button type="submit" class="btn btn-primary w-100">
                <i class="ti ti-login me-2"></i>
                Sign in
              </button>
            </div>

          </form>

        </div>
      </div>

      <div class="text-center text-secondary mt-3">
        <small>&copy; <?php echo date('Y'); ?> Pendragon System. All rights reserved.</small>
      </div>

    </div>
  </div>

  <!-- jQuery -->
  <script src="assets/js/jquery.min.js"></script>

  <!-- Toastr -->
  <script src="assets/js/toastr.min.js"></script>

  <!-- Tabler -->
  <script src="assets/js/tabler.min.js"></script>

  <!-- Login -->
  <script src="assets/js/login.js"></script>

</body>

</html>


<script>
  $(document).ready(function () {

    toastr.options = {
      closeButton: true,
      progressBar: true,
      positionClass: "toast-top-right",
      timeOut: 3000
    };

    $('#loginForm').on('submit', function (e) {
      e.preventDefault();

      const btn = $(this).find('button[type="submit"]');
      const originalText = btn.html();

      btn.prop('disabled', true);
      btn.html('<i class="ti ti-loader me-2"></i> Signing in...');

      $.ajax({
        url: './controllers/login_process.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',

        success: function (response) {
          if (response.success) {
            toastr.success(response.message);

            setTimeout(function () {
              window.location.href = response.redirect;
            }, 300);
          } else {
            toastr.error(response.message);
            btn.prop('disabled', false);
            btn.html(originalText);
          }
        },

        error: function (xhr) {
          console.error(xhr.responseText);
          toastr.error('Server error. Please try again.');

          btn.prop('disabled', false);
          btn.html(originalText);
        }
      });
    });

  });

</script>