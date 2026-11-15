<header class="navbar navbar-expand-xxl d-print-none main-navbar">
  <div class="container-fluid">

    <!-- MOBILE TOGGLE -->
    <button class="navbar-toggler me-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
      aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- LOGO -->
    <a href="dashboard.php" class="navbar-brand navbar-brand-autodark">
      <span class="brand-logo">
        <img src="logo.svg" alt="Pendragon Logo">
      </span>
    </a>

    <!-- USER PROFILE -->
    <div class="navbar-nav flex-row order-xxl-last ms-auto">
      <div class="nav-item dropdown">

        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu"
          aria-expanded="false">

          <span class="avatar avatar-sm">GG</span>

          <div class="d-none d-sm-block ps-2">
            <div>Admin</div>
            <div class="mt-1 small text-secondary">Administrator</div>
          </div>

        </a>

        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">

          <a href="profile.php" class="dropdown-item">
            <i class="ti ti-user me-2"></i>
            Profile
          </a>

          <a href="feedback.php" class="dropdown-item">
            <i class="ti ti-message-circle me-2"></i>
            Feedback
          </a>

          <div class="dropdown-divider"></div>

          <a href="settings.php" class="dropdown-item">
            <i class="ti ti-settings me-2"></i>
            Settings
          </a>

          <a href="./../controllers/logout_process.php" class="dropdown-item">
            <i class="ti ti-logout me-2"></i>
            Logout
          </a>

        </div>
      </div>
    </div>

    <!-- NAVIGATION MENU -->
    <div class="collapse navbar-collapse" id="navbar-menu">

      <ul class="navbar-nav">

        <!-- DASHBOARD -->
        <li class="nav-item">
          <a class="nav-link active" href="dashboard.php">
            <span class="nav-link-icon">
              <i class="ti ti-dashboard"></i>
            </span>
            <span class="nav-link-title">Dashboard</span>
          </a>
        </li>

        <!-- CASE -->
        <li class="nav-item">
          <a class="nav-link" href="case.php">
            <span class="nav-link-icon">
              <i class="ti ti-folder"></i>
            </span>
            <span class="nav-link-title">Case</span>
          </a>
        </li>

        <!-- CLIENTS -->
        <li class="nav-item">
          <a class="nav-link" href="client.php">
            <span class="nav-link-icon">
              <i class="ti ti-users"></i>
            </span>
            <span class="nav-link-title">Clients</span>
          </a>
        </li>

        <!-- PATIENT -->
        <li class="nav-item">
          <a class="nav-link" href="patient.php">
            <span class="nav-link-icon">
              <i class="ti ti-paw"></i>
            </span>
            <span class="nav-link-title">Patient</span>
          </a>
        </li>

        <!-- BILLING -->
        <li class="nav-item">
          <a class="nav-link" href="billing.php">
            <span class="nav-link-icon">
              <i class="ti ti-receipt"></i>
            </span>
            <span class="nav-link-title">Billing</span>
          </a>
        </li>

        <!-- PURCHASE ORDER -->
        <li class="nav-item">
          <a class="nav-link" href="purchase_order.php">
            <span class="nav-link-icon">
              <i class="ti ti-shopping-cart"></i>
            </span>
            <span class="nav-link-title">Purchase Order</span>
          </a>
        </li>

        <!-- MED PATHWAY -->
        <li class="nav-item">
          <a class="nav-link" href="med_pathway.php">
            <span class="nav-link-icon">
              <i class="ti ti-heartbeat"></i>
            </span>
            <span class="nav-link-title">Med Pathway</span>
          </a>
        </li>

        <!-- REPORT -->
        <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="nav-link-icon">
              <i class="ti ti-chart-bar"></i>
            </span>
            <span class="nav-link-title">Report</span>
          </a>

          <div class="dropdown-menu">
            <a href="case_report.php" class="dropdown-item">
              <i class="ti ti-file-text me-2"></i>
              Case Report
            </a>

            <a href="patient_report.php" class="dropdown-item">
              <i class="ti ti-users me-2"></i>
              Patient Report
            </a>

            <a href="billing_report.php" class="dropdown-item">
              <i class="ti ti-report-money me-2"></i>
              Billing Report
            </a>
          </div>
        </li>

        <!-- USER -->
        <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="nav-link-icon">
              <i class="ti ti-user-cog"></i>
            </span>
            <span class="nav-link-title">User</span>
          </a>

          <div class="dropdown-menu">
            <a href="users.php" class="dropdown-item">
              <i class="ti ti-users me-2"></i>
              User Management
            </a>

            <a href="user_roles.php" class="dropdown-item">
              <i class="ti ti-shield-lock me-2"></i>
              User Roles Management
            </a>
          </div>
        </li>

        <!-- SETUP -->
        <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="nav-link-icon">
              <i class="ti ti-settings"></i>
            </span>
            <span class="nav-link-title">Setup</span>
          </a>

          <div class="dropdown-menu">
            <a href="general_settings.php" class="dropdown-item">
              <i class="ti ti-adjustments me-2"></i>
              General Settings
            </a>

            <a href="categories.php" class="dropdown-item">
              <i class="ti ti-category me-2"></i>
              Categories
            </a>

            <a href="system_settings.php" class="dropdown-item">
              <i class="ti ti-tool me-2"></i>
              System Settings
            </a>
          </div>
        </li>

        <!-- SMS -->
        <li class="nav-item">
          <a class="nav-link" href="sms.php">
            <span class="nav-link-icon">
              <i class="ti ti-message"></i>
            </span>
            <span class="nav-link-title">SMS</span>
          </a>
        </li>

      </ul>

    </div>
    <!-- END NAVIGATION MENU -->

  </div>
</header>

<!-- TABLER JAVASCRIPT -->
<!-- <script src="assets/js/tabler.min.js"></script> -->

<!-- Protect Pages when not logged in -->
<script>
  window.addEventListener("pageshow", function (event) {
    if (event.persisted) {
      window.location.reload();
    }
  });
</script>