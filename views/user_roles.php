<?php
include './../connections/connections.php';

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['user_id'])) {
  header("Location: /pendragonsystem2027/index.php");
  exit();
}

$page_title = 'User Roles Management';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?php echo $page_title ?? 'User Roles'; ?></title>

  <!-- TABLER CSS -->
  <link rel="stylesheet" href="/pendragonsystem2027/assets/css/tabler.min.css">
  <link rel="stylesheet" href="/pendragonsystem2027/assets/css/tabler-icons.min.css">

  <!-- TOASTR CSS -->
  <link rel="stylesheet" href="/pendragonsystem2027/assets/css/toastr.min.css">

  <!-- DATATABLES CSS -->
  <link rel="stylesheet" href="/pendragonsystem2027/assets/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="/pendragonsystem2027/assets/css/responsive.bootstrap5.min.css">

  <!-- CUSTOM CSS -->
  <link rel="stylesheet" href="/pendragonsystem2027/assets/css/static.css">

</head>

<body>

  <!-- Navigation Bar -->
  <?php include './../includes/navbar.php'; ?>

  <!-- Modal Add User -->

  <!-- PAGE WRAPPER -->
  <div class="page-wrapper">

    <!-- PAGE HEADER -->
    <div class="page-header d-print-none">
      <div class="container-xl">

        <div class="row g-2 align-items-center">

          <div class="col">
            <h2 class="page-title">
              User Roles Management
            </h2>

            <div class="text-secondary mt-1">
              Manage user roles and permissions.
            </div>
          </div>

          <div class="col-auto ms-auto">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">

              <i class="ti ti-plus me-1"></i>
              Add Role

            </button>
          </div>

        </div>

      </div>
    </div>


    <!-- PAGE BODY -->
    <div class="page-body">
      <div class="container-xl">

        <div class="card card-gradient card-gradient-ocean">

          <div class="card-header">
            <h3 class="card-title">
              User Roles List
            </h3>
          </div>

          <div class="card-body">

            <div class="table-responsive">

              <table id="usersTable" class="table table-vcenter table-striped">

                <thead>
                  <tr>
                    <th>ID</th>
                    <th>User Role</th>
                    <th>Case Doctor Status</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>

                <tbody>

                  <?php

                  $query = "SELECT * FROM z_user_restriction ORDER BY user_type_id DESC";
                  $result = mysqli_query($conn, $query);

                  if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                      $case_doctor = $row['case_doctor'] ?? 'enabled';

                      ?>

                      <tr>
                        <td>
                          <?php echo htmlspecialchars($row['user_type_id']); ?>
                        </td>
                        <td>
                          <?php echo htmlspecialchars($row['user_type_name']); ?>
                        </td>
                        <td>
                          <?php if ($case_doctor == 'enabled') { ?>
                            <span class="badge bg-success-lt">
                              Active
                            </span>

                          <?php } else { ?>
                            <span class="badge bg-danger-lt">
                              Inactive
                            </span>
                          <?php } ?>
                        </td>

                        <td class="text-center">
                          <button type="button" class="btn btn-sm btn-outline-primary">
                            <i class="ti ti-edit me-1"></i>
                            Edit
                          </button>

                          <button type="button" class="btn btn-sm btn-outline-danger">
                            <i class="ti ti-trash me-1"></i>
                            Delete
                          </button>
                        </td>

                      </tr>

                      <?php

                    }

                  }

                  ?>

                </tbody>

              </table>

            </div>

          </div>

        </div>

      </div>
    </div>

  </div>


  <!-- JQUERY -->
  <script src="/pendragonsystem2027/assets/js/jquery.min.js"></script>

  <!-- TABLER JAVASCRIPT -->
  <script src="/pendragonsystem2027/assets/js/tabler.min.js"></script>

  <!-- TOASTR JAVASCRIPT -->
  <script src="/pendragonsystem2027/assets/js/toastr.min.js"></script>

  <!-- DATATABLES JAVASCRIPT -->
  <script src="/pendragonsystem2027/assets/js/dataTables.min.js"></script>
  <script src="/pendragonsystem2027/assets/js/dataTables.bootstrap5.min.js"></script>

  <!-- DATATABLES RESPONSIVE -->
  <script src="/pendragonsystem2027/assets/js/dataTables.responsive.min.js"></script>
  <script src="/pendragonsystem2027/assets/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>

  <?php include './../modals/user_type/modal_add_user_type.php'; ?>

  <!-- DATATABLES INITIALIZATION -->
  <script>
    $(document).ready(function () {

      $('#usersTable').DataTable({

        responsive: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],
        order: [[0, 'desc']],

        columnDefs: [
          { targets: 3, orderable: false, searchable: false }
        ],

        language: {
          search: "",
          searchPlaceholder: "Search users...",
          emptyTable: "No users available | Try adding a new user.",
          zeroRecords: "No matching users found"
        }

      });

    });
  </script>

</body>

</html>