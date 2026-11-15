<?php
include './../connections/connections.php';

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['user_id'])) {
  header("Location: /pendragonsystem2027/index.php");
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- FAVICON -->
  <link rel="icon" type="image/png" href="/pendragonsystem2027/views/ico.jpg">

  <title>Users Management</title>

  <!-- ALL THE CSS -->
  <?php include './../includes/css_upper.php'; ?>

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
              Users Management
            </h2>

            <div class="text-secondary mt-1">
              Manage your system users.
            </div>
          </div>

          <div class="col-auto ms-auto">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">

              <i class="ti ti-plus me-1"></i>
              Add User

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
              User List
            </h3>
          </div>

          <div class="card-body">

            <div class="table-responsive">

              <table id="usersTable" class="table table-vcenter table-striped">

                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>

                <tbody>

                  <?php

                  $query = "SELECT * FROM z_user ORDER BY user_id DESC";
                  $result = mysqli_query($conn, $query);

                  if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                      $user_status = $row['user_status'] ?? 'enabled';

                      ?>

                      <tr>
                        <td>
                          <?php echo htmlspecialchars($row['user_id']); ?>
                        </td>
                        <td>
                          <?php echo htmlspecialchars($row['user_firstname'] . ' ' . $row['user_lastname']); ?>
                        </td>
                        <td>
                          <?php echo htmlspecialchars($row['user_name']); ?>
                        </td>
                        <td>
                          <?php echo htmlspecialchars($row['user_email']); ?>
                        </td>
                        <td>
                          <?php if ($user_status == 'enabled') { ?>
                            <span class="badge bg-success-lt">
                              Active
                            </span>

                          <?php } else { ?>
                            <span class="badge bg-danger-lt">
                              Locked
                            </span>
                          <?php } ?>
                        </td>

                        <td class="text-center">
                          <button type="button" class="btn btn-sm btn-outline-primary btn-edit-user"
                            data-user-id="<?php echo htmlspecialchars($row['user_id']); ?>">

                            <i class="ti ti-edit me-1"></i>
                            Edit
                          </button>

                          <button type="button" class="btn btn-sm btn-outline-danger btn-lock-user" style="width: 90px;"
                            data-user-id="<?php echo htmlspecialchars($row['user_id']); ?>"
                            data-user-status="<?php echo htmlspecialchars($user_status); ?>">

                            <?php if ($user_status == 'enabled') { ?>
                              <i class="ti ti-lock me-1"></i>
                              Lock
                            <?php } else { ?>
                              <i class="ti ti-lock-open me-1"></i>
                              Unlock
                            <?php } ?>

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

  <!-- All JavaScript -->
  <?php include './../includes/js_lower.php'; ?>

  <?php include './../modals/users/modal_add_users.php'; ?>

  <!-- DATATABLES INITIALIZATION -->
  <script>
    // Selectize Initialization
    $(document).ready(function () {
      $('select').selectize({
        sortField: 'text'
      });
    });

    // DataTables Initialization
    $(document).ready(function () {
      $('#usersTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],
        order: [[0, 'desc']],

        columnDefs: [
          { targets: 5, orderable: false, searchable: false }
        ],

        language: {
          search: "",
          searchPlaceholder: "Search users...",
          emptyTable: "No users available | Try adding a new user.",
          zeroRecords: "No matching users found"
        }

      });

    });

    // LOAD EDIT USER MODAL
    $(document).on('click', '.btn-edit-user', function () {

      var userId = $(this).data('user-id');
      $.ajax({
        url: './../modals/users/modal_edit_users.php',
        type: 'POST',
        data: {
          user_id: userId
        },

        success: function (response) {
          // console.log('Modal loaded for User Type ID:', userId);
          $('#editUserModal').remove();
          $('body').append(response);

          // Initialize Selectize for the edit user modal
          $('select').selectize({
            sortField: 'text'
          });

          $('#editUserModal').modal('show');

        },

        error: function (xhr) {
          console.log('AJAX Error:', xhr.status);
          console.log(xhr.responseText);
          toastr.error('Unable to load user role details.');
        }
      });
    });

    // LOCK USER ACCOUNT
    $(document).on('click', '.btn-lock-user', function () {

      var userId = $(this).data('user-id');
      $.ajax({
        url: './../modals/users/modal_status_user.php',
        type: 'POST',
        data: {
          user_id: userId
        },

        success: function (response) {
          // console.log('Modal loaded for User Type ID:', userId);
          $('#lockUserModal').remove();
          $('body').append(response);

          // Initialize Selectize for the lock user modal
          $('select').selectize({
            sortField: 'text'
          });
          $('#lockUserModal').modal('show');

        },

        error: function (xhr) {
          console.log('AJAX Error:', xhr.status);
          console.log(xhr.responseText);
          toastr.error('Unable to load user role details.');
        }
      });
    });
  </script>

</body>

</html>