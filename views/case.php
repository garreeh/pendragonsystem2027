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

  <title>Case Management</title>

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
              Case Management
            </h2>

            <div class="text-secondary mt-1">
              Manage your cases.
            </div>
          </div>

          <!-- <div class="col-auto ms-auto">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCaseModal">

              <i class="ti ti-plus me-1"></i>
              Add Case

            </button>
          </div> -->

        </div>

      </div>
    </div>


    <!-- PAGE BODY -->
    <div class="page-body">
      <div class="container-fluid">

        <div class="card card-gradient card-gradient-ocean">

          <div class="card-header">
            <h3 class="card-title">
              Case List
            </h3>
          </div>

          <div class="card-body">

            <div class="table-responsive">

              <table id="caseTable" class="table table-vcenter table-striped">

                <thead>
                  <tr>
                    <th>Case ID</th>
                    <th>Case Date </th>
                    <th>Patient Name</th>
                    <th>Owner</th>
                    <th>Attending Vet</th>
                    <th>Chief Complaint</th>
                    <th>Clinical Symptoms</th>
                    <th>Lab Requested</th>
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

    // DATATABLES INITIALIZATION
    $(document).ready(function () {
      // Initialize DataTables - Server Side Processing
      var caseTable = $('#caseTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
        deferRender: true,

        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],
        ajax: {
          url: './../controllers/tables/fetch_cases.php',
          type: 'POST',
          error: function (xhr) {
            console.error('AJAX Error:', xhr.responseText);

            if (xhr.status === 401) {
              window.location.href =
                '/pendragonsystem2027/index.php';
            } else {
              toastr.error('Unable to load case records.');
            }
          }
        },

        columns: [
          {
            data: 'case_id',
            render: function (data, type, row) {
              if (type !== 'display') return data;

              return `<a href="case_details.php?case_id=${encodeURIComponent(data)}"
                       class="text-primary fw-bold">
                       ${$('<div>').text(data).html()}
                    </a>`;
            }
          },
          {
            data: 'case_date',
            render: function (data, type, row) {
              if (type !== 'display') return data;

              return `<a href="case_details.php?case_id=${encodeURIComponent(row.case_id)}"
                   class="text-primary fw-bold">
                   ${$('<div>').text(data || '').html()}
                </a>`;
            }
          },
          {
            data: 'patient_name',
            render: function (data, type, row) {
              if (type !== 'display') return data;

              return `<a href="case_details.php?case_id=${encodeURIComponent(row.case_id)}"
                   class="text-primary fw-bold">
                   ${$('<div>').text(data || '').html()}
                </a>`;
            }
          },
          {
            data: 'owner_name',
            render: $.fn.dataTable.render.text()
          },
          {
            data: 'attending_vet',
            render: $.fn.dataTable.render.text()
          },
          {
            data: 'case_chief_complaint',
            render: $.fn.dataTable.render.text()
          },
          {
            data: 'case_clinical_symptom',
            render: $.fn.dataTable.render.text()
          },
          {
            data: 'case_laboratory_requested',
            render: $.fn.dataTable.render.text()
          },
          {
            data: 'case_id',
            orderable: false,
            searchable: false,
            render: function (data, type, row) {

              if (type !== 'display') {
                return data;
              }

              return `
                <div class="d-flex justify-content-center gap-1">

                    <button type="button"
                        class="btn btn-sm btn-outline-primary btn-edit-case"
                        data-case-id="${Number(data)}">
                        <i class="ti ti-edit me-1"></i>
                        Edit
                    </button>

                    <button type="button"
                        class="btn btn-sm btn-outline-danger btn-delete-case"
                        data-case-id="${Number(data)}">
                        <i class="ti ti-trash me-1"></i>
                        Delete
                    </button>

                </div>
                    `;
            }
          }

        ],

        order: [[0, 'desc']],

        language: {

          search: "",
          searchPlaceholder: "Search cases...",
          emptyTable: "No cases available. Try adding a new case.",
          zeroRecords: "No matching cases found.",
          infoFiltered: "(filtered from _MAX_ total cases)"

        }

      });


      // Edit Case Button
      $(document).on('click', '.btn-edit-case', function () {
        var caseId = $(this).data('case-id');
        console.log('Selected Case ID:', caseId);
        // Load your edit case modal here using AJAX.
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

  </script>

</body>

</html>