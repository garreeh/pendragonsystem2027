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

  <title>Client Management</title>

  <!-- CSS -->
  <?php include './../includes/css_upper.php'; ?>
</head>

<body>

  <!-- NAVIGATION BAR -->
  <?php include './../includes/navbar.php'; ?>

  <!-- PAGE WRAPPER -->
  <div class="page-wrapper">

    <!-- PAGE HEADER -->
    <div class="page-header d-print-none">
      <div class="container-fluid">

        <div class="row g-2 align-items-center">

          <div class="col">
            <h2 class="page-title">
              Client Management
            </h2>

            <div class="text-secondary mt-1">
              Manage your clients.
            </div>
          </div>

          <div class="col-auto ms-auto">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addClientModal">

              <i class="ti ti-plus me-1"></i>
              Add Client

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
              Client List
            </h3>
          </div>

          <div class="card-body">

            <div class="table-responsive">

              <table id="clientTable" class="table table-vcenter table-striped">

                <thead>
                  <tr>
                    <th>Client ID</th>
                    <th>Client Name</th>
                    <th>Date Created</th>
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

  <!-- JAVASCRIPT -->
  <?php include './../includes/js_lower.php'; ?>
  <?php include './../modals/clients/modal_add_client.php'; ?>

  <script>

    $(document).ready(function () {

      // Initialize Client DataTable
      var clientTable = $('#clientTable').DataTable({

        processing: true,
        serverSide: true,
        deferRender: true,
        responsive: false,

        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],

        searchDelay: 400,

        ajax: {
          url: './../controllers/tables/fetch_clients.php',
          type: 'POST',

          error: function (xhr) {

            console.error('AJAX Error:', xhr.responseText);

            if (xhr.status === 401) {
              window.location.href = '/pendragonsystem2027/index.php';
            } else {
              toastr.error('Unable to load client records.');
            }

          }
        },

        columns: [

          // CLIENT ID
          {
            data: 'client_id',
            render: function (data, type, row) {
              if (type !== 'display') return data;

              return `<a href="client_details.php?client_id=${encodeURIComponent(data)}"
                       class="text-primary fw-bold">
                       ${$('<div>').text(data).html()}
                    </a>`;
            }
          },

          // CLIENT FULL NAME
          {
            data: 'full_name',
            render: $.fn.dataTable.render.text()
          },

          // DATE CREATED
          {
            data: 'client_datecreated',
            render: $.fn.dataTable.render.text()
          },

          // ACTION BUTTONS
          {
            data: null,
            orderable: false,
            searchable: false,
            className: 'text-center',

            render: function (data, type, row) {

              if (type !== 'display') {
                return data;
              }

              var clientId = Number(row.client_id);
              var clientLocked = row.client_locked;

              var lockButton = '';

              if (clientLocked == 'yes') {

                lockButton =
                  '<button type="button" class="btn btn-sm btn-outline-danger btn-lock-client" style="width: 90px;" data-client-id="' + clientId + '" data-client-locked="yes">' +
                  '<i class="ti ti-lock me-1"></i>Lock</button>';

              } else {

                lockButton =
                  '<button type="button" class="btn btn-sm btn-outline-success btn-lock-client" style="width: 90px;" data-client-id="' + clientId + '" data-client-locked="no">' +
                  '<i class="ti ti-lock-open me-1"></i>Unlock</button>';
              }

              return '<div class="d-flex justify-content-center gap-1">' +

                // EDIT
                '<button type="button" class="btn btn-sm btn-outline-primary btn-edit-client" data-client-id="' + clientId + '">' +
                '<i class="ti ti-edit me-1"></i>Edit</button>' +

                // DELETE
                '<button type="button" class="btn btn-sm btn-outline-danger btn-delete-client" data-client-id="' + clientId + '">' +
                '<i class="ti ti-trash me-1"></i>Delete</button>' +

                // LOCK / UNLOCK
                lockButton +

                '</div>';
            }
          }

        ],

        order: [[0, 'desc']],

        language: {
          search: '',
          searchPlaceholder: 'Search clients...',
          emptyTable: 'No clients available.',
          zeroRecords: 'No matching clients found.',
          processing: 'Loading clients...',
          infoFiltered: '(filtered from _MAX_ total clients)'
        }

      });


      // EDIT CLIENT BUTTON
      $(document).on('click', '.btn-edit-client', function () {

        var editButton = $(this);
        var originalText = editButton.html();

        // Prevent repeated clicks
        if (editButton.prop('disabled')) {
          return;
        }

        var clientId = editButton.data('client-id');

        // Disable button and show loading
        editButton.prop('disabled', true);
        editButton.html('<i class="ti ti-loader me-2"></i> Loading...');

        $.ajax({
          url: './../modals/clients/modal_edit_client.php',
          type: 'POST',
          data: {
            client_id: clientId
          },

          success: function (response) {

            $('#editClientModal').remove();

            $('body').append(response);

            $('#editClientModal').modal('show');

          },

          error: function (xhr) {

            console.log('AJAX Error:', xhr.status);
            console.log(xhr.responseText);

            toastr.error('Unable to load client details.');

          },

          complete: function () {

            // Restore Edit button
            editButton.prop('disabled', false);
            editButton.html(originalText);

          }
        });

      });


      // DELETE CLIENT BUTTON
      $(document).on('click', '.btn-delete-client', function () {

        var clientId = $(this).data('client-id');

        console.log('Selected Client ID:', clientId);

        // Load your Delete Client confirmation modal here.
        // Use clientId to identify the selected client.

      });


      // LOCK CLIENT BUTTON
      $(document).on('click', '.btn-lock-client', function () {

        var clientId = $(this).data('client-id');

        $.ajax({
          url: './../modals/clients/modal_status_clients.php',
          type: 'POST',
          data: {
            client_id: clientId
          },

          success: function (response) {
            // console.log('Modal loaded for User Type ID:', clientId);
            $('#lockClientModal').remove();
            $('body').append(response);
            $('#lockClientModal').modal('show');

          },

          error: function (xhr) {
            console.log('AJAX Error:', xhr.status);
            console.log(xhr.responseText);
            toastr.error('Unable to load user role details.');
          }
        });

      });


      // REFRESH CLIENT TABLE AFTER ADD / EDIT / DELETE
      // Call this after a successful database operation:
      //
      // clientTable.ajax.reload(null, false);

    });

  </script>

</body>

</html>