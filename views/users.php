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
      <div class="container-fluid">

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
      <div class="container-fluid">

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

    // Initialize DataTable for Users Table
    $(document).ready(function () {
      $('#usersTable').DataTable({
        processing: true,
        serverSide: true,
        deferRender: true,
        ajax: {
          url: './../controllers/tables/fetch_users.php',
          type: 'POST',

          // For Debugging: Log the JSON response to the console
          // dataSrc: function (json) {
          //   console.log('DataTables JSON Response:', json);
          //   console.log('User Records:', json.data);
          //   return json.data;
          // },

          error: function (xhr) {
            console.log('AJAX Error:', xhr.responseText);
            toastr.error('Unable to retrieve users.');
          }
        },

        responsive: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],
        searchDelay: 400,
        order: [[0, 'desc']],

        columns: [

          {
            data: 'user_id',
            render: function (data, type, row) {
              if (type !== 'display') return data;

              return `<a href="user_details.php?user_id=${encodeURIComponent(data)}"
                   class="text-primary fw-bold">
                   ${$('<div>').text(data).html()}
                </a>`;
            }
          },

          {
            data: 'full_name',
            render: $.fn.dataTable.render.text()
          },

          {
            data: 'user_name',
            render: $.fn.dataTable.render.text()
          },

          {
            data: 'user_email',
            render: $.fn.dataTable.render.text()
          },

          {
            data: 'user_status',
            render: function (data, type, row) {

              if (type !== 'display') {
                return data;
              }

              if (data == 'enabled') {
                return '<span class="badge bg-success-lt">Active</span>';
              } else {
                return '<span class="badge bg-danger-lt">Locked</span>';
              }
            }
          },

          {
            data: null,
            orderable: false,
            searchable: false,
            className: 'text-center',

            render: function (data, type, row) {

              var userId = Number(row.user_id);
              var userStatus = row.user_status;

              var lockButton = '';

              if (userStatus == 'enabled') {
                lockButton =
                  '<button type="button" class="btn btn-sm btn-outline-danger btn-lock-user" style="width: 90px;" data-user-id="' + userId + '" data-user-status="enabled">' +
                  '<i class="ti ti-lock me-1"></i>Lock</button>';
              } else {
                lockButton =
                  '<button type="button" class="btn btn-sm btn-outline-success btn-lock-user" style="width: 90px;" data-user-id="' + userId + '" data-user-status="' + $('<div>').text(userStatus).html() + '">' +
                  '<i class="ti ti-lock-open me-1"></i>Unlock</button>';
              }

              return '<div class="d-flex justify-content-center gap-1">' +
                '<button type="button" class="btn btn-sm btn-outline-primary btn-edit-user" data-user-id="' + userId + '">' +
                '<i class="ti ti-edit me-1"></i>Edit</button>' +
                lockButton +
                '</div>';
            }
          }

        ],

        language: {
          search: '',
          searchPlaceholder: 'Search users...',
          emptyTable: 'No users available | Try adding a new user.',
          zeroRecords: 'No matching users found',
          processing: 'Loading users...'
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