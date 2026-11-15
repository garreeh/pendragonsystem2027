<?php
include './../connections/connections.php';

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['user_id'])) {
  header("Location: /pendragonsystem2027/index.php");
  exit();
}

include './../controllers/count_user_dashboard.php';


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?php echo $page_title; ?></title>

  <!-- TABLER CSS -->
  <link rel="stylesheet" href="/pendragonsystem2027/assets/css/tabler.min.css">
  <link rel="stylesheet" href="/pendragonsystem2027/assets/css/tabler-icons.min.css">
  <link rel="stylesheet" href="/pendragonsystem2027/assets/css/static.css">
</head>

<body>

  <!-- NAVBAR -->
  <?php include './../includes/navbar.php'; ?>

  <div class="page-wrapper">

    <!-- PAGE HEADER -->
    <div class="page-header d-print-none">
      <div class="container-xl">
        <div class="row g-2 align-items-center">
          <div class="col">
            <h2 class="page-title">Dashboard</h2>
            <div class="text-secondary mt-1">
              Welcome back! Here's your system overview.
            </div>
          </div>
          <div class="col-auto ms-auto">
            <span class="text-secondary">
              <i class="ti ti-calendar me-1"></i>
              <?php echo date('F d, Y'); ?>
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- PAGE BODY -->
    <div class="page-body">
      <div class="container-xl">

        <!-- STATISTICS -->
        <div class="row row-cards mb-3">

          <div class="col-sm-6 col-lg-4">
            <div class="card card-gradient card-gradient-info">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div class="subheader">Total Users</div>
                  <div class="ms-auto">
                    <span class="avatar bg-primary-lt">
                      <i class="ti ti-users fs-2"></i>
                    </span>
                  </div>
                </div>
                <div class="h1 mb-0">
                  <?php echo number_format($total_users); ?>
                </div>
                <div class="text-secondary mt-1">
                  Registered users
                </div>
              </div>
            </div>
          </div>

          <div class="col-sm-6 col-lg-4">
            <div class="card card-gradient card-gradient-success">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div class="subheader">Active Users</div>
                  <div class="ms-auto">
                    <span class="avatar bg-success-lt">
                      <i class="ti ti-user-check fs-2"></i>
                    </span>
                  </div>
                </div>
                <div class="h1 mb-0">
                  <?php echo number_format($active_users); ?>
                </div>
                <div class="text-secondary mt-1">
                  Enabled accounts
                </div>
              </div>
            </div>
          </div>

          <div class="col-sm-6 col-lg-4">
            <div class="card card-gradient card-gradient-danger">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div class="subheader">Inactive Users</div>
                  <div class="ms-auto">
                    <span class="avatar bg-danger-lt">
                      <i class="ti ti-user-x fs-2"></i>
                    </span>
                  </div>
                </div>
                <div class="h1 mb-0">
                  <?php echo number_format($inactive_users); ?>
                </div>
                <div class="text-secondary mt-1">
                  Disabled accounts
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>
    </div>

  </div>

  <!-- TABLER JAVASCRIPT -->
  <script src="/pendragonsystem2027/assets/js/tabler.min.js"></script>

</body>

</html>