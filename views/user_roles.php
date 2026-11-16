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

  <title>User Roles Management</title>

  <!-- ALL CSS -->
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
              User Roles Management
            </h2>

            <div class="text-secondary mt-1">
              Manage user roles and permissions.
            </div>
          </div>

          <div class="col-auto ms-auto">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserTypeModal">

              <i class="ti ti-plus me-1"></i>
              Add Role

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
              User Roles List
            </h3>
          </div>

          <div class="card-body">

            <div class="table-responsive">

              <table id="usersTypeTable" class="table table-vcenter table-striped">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>User Role</th>
                    <th>Case Doctor Status</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>


            </div>

          </div>

        </div>

      </div>
    </div>

  </div>

  <!-- All JavaScript -->
  <?php include './../includes/js_lower.php'; ?>

  <?php include './../modals/user_type/modal_add_user_type.php'; ?>
  <!-- DATATABLES INITIALIZATION -->
  <script>

    $(document).ready(function () {

      $('#usersTypeTable').DataTable({

        processing: true,
        serverSide: true,
        deferRender: true,

        ajax: {
          url: './../controllers/tables/fetch_user_types.php',
          type: 'POST',

          error: function (xhr) {
            console.log('AJAX Error:', xhr.responseText);
            toastr.error('Unable to retrieve user roles.');
          }
        },

        responsive: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],
        searchDelay: 400,
        order: [[0, 'desc']],

        columns: [

          {
            data: 'user_type_id',
            render: $.fn.dataTable.render.text()
          },

          {
            data: 'user_type_name',
            render: $.fn.dataTable.render.text()
          },

          {
            data: 'case_doctor',
            render: function (data, type, row) {

              if (type !== 'display') {
                return data;
              }

              if (data == 'enabled') {
                return '<span class="badge bg-success-lt">Enabled</span>';
              } else {
                return '<span class="badge bg-danger-lt">Disabled</span>';
              }
            }
          },

          {
            data: null,
            orderable: false,
            searchable: false,
            className: 'text-center',

            render: function (data, type, row) {

              var userTypeId = Number(row.user_type_id);

              return '<button type="button" class="btn btn-sm btn-outline-primary btn-edit-user" data-user-type-id="' + userTypeId + '">' +
                '<i class="ti ti-edit me-1"></i>Edit</button>';
            }
          }

        ],

        language: {
          search: '',
          searchPlaceholder: 'Search user roles...',
          emptyTable: 'No user roles available | Try adding a new user role.',
          zeroRecords: 'No matching user roles found',
          processing: 'Loading user roles...'
        }

      });

    });


    // LOAD EDIT USER TYPE MODAL
    $(document).on('click', '.btn-edit-user', function () {

      var userTypeId = $(this).data('user-type-id');
      // console.log('Clicked Edit - User Type ID:', userTypeId);
      $.ajax({
        url: './../modals/user_type/modal_edit_user_type.php',
        type: 'POST',
        data: {
          user_type_id: userTypeId
        },

        success: function (response) {
          // console.log('Modal loaded for User Type ID:', userTypeId);
          $('#editUserTypeModal').remove();
          $('body').append(response);
          $('#editUserTypeModal').modal('show');

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