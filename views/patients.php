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

  <title>Patient Management</title>

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
              Patient Management
            </h2>

            <div class="text-secondary mt-1">
              Manage your patients.
            </div>
          </div>

          <!-- <div class="col-auto ms-auto">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPatientModal">

              <i class="ti ti-plus me-1"></i>
              Add Patient

            </button> -->
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
            Patient List
          </h3>
        </div>

        <div class="card-body">

          <div class="table-responsive">

            <table id="patientTable" class="table table-vcenter table-striped">

              <thead>
                <tr>
                  <th>Patient ID</th>
                  <th>Microchip</th>
                  <th>Patient Name</th>
                  <th>Owner Fullname</th>
                  <th>Species</th>
                  <th>Breed</th>
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

  <script>

    $(document).ready(function () {

      // Initialize Patient DataTable
      var patientTable = $('#patientTable').DataTable({

        processing: true,
        serverSide: true,
        deferRender: true,
        responsive: false,

        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],

        searchDelay: 400,

        ajax: {
          url: './../controllers/tables/fetch_patients.php',
          type: 'POST',

          error: function (xhr) {

            console.error('AJAX Error:', xhr.responseText);

            if (xhr.status === 401) {
              window.location.href = '/pendragonsystem2027/index.php';
            } else {
              toastr.error('Unable to load patient records.');
            }
          }
        },

        columns: [

          // PATIENT ID
          {
            data: 'patient_id',

            render: function (data, type, row) {

              if (type !== 'display') {
                return data;
              }

              return '<a href="patient_details.php?patient_id=' +
                encodeURIComponent(data) +
                '" class="text-primary fw-bold">' +
                $('<div>').text(data).html() +
                '</a>';
            }
          },

          // MICROCHIP
          {
            data: 'patient_microchip',
            defaultContent: '',
            render: $.fn.dataTable.render.text()
          },

          // PATIENT NAME
          {
            data: 'patient_name',
            defaultContent: '',
            render: $.fn.dataTable.render.text()
          },

          // OWNER FULL NAME
          {
            data: 'owner_fullname',
            defaultContent: '',
            render: $.fn.dataTable.render.text()
          },

          // SPECIES
          {
            data: 'species_name',
            defaultContent: '',
            render: $.fn.dataTable.render.text()
          },

          // BREED
          {
            data: 'breed_name',
            defaultContent: '',
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
                return '';
              }

              var patientId = Number(row.patient_id);

              return '<div class="d-flex justify-content-center gap-1">' +

                // EDIT
                '<button type="button" class="btn btn-sm btn-outline-primary btn-edit-patient" data-patient-id="' + patientId + '">' +
                '<i class="ti ti-edit me-1"></i>Edit</button>' +

                // DELETE
                '<button type="button" class="btn btn-sm btn-outline-danger btn-delete-patient" data-patient-id="' + patientId + '">' +
                '<i class="ti ti-trash me-1"></i>Delete</button>' +

                '</div>';
            }
          }

        ],

        order: [[0, 'desc']],

        language: {
          search: '',
          searchPlaceholder: 'Search patients...',
          emptyTable: 'No patients available.',
          zeroRecords: 'No matching patients found.',
          processing: 'Loading patients...',
          infoFiltered: '(filtered from _MAX_ total patients)'
        }

      });


      // EDIT PATIENT BUTTON
      $(document).on('click', '.btn-edit-patient', function () {

        var patientId = $(this).data('patient-id');

        console.log('Selected Patient ID:', patientId);

        // Load your Edit Patient modal here.
      });


      // DELETE PATIENT BUTTON
      $(document).on('click', '.btn-delete-patient', function () {

        var patientId = $(this).data('patient-id');

        console.log('Selected Patient ID:', patientId);

        // Load your Delete Patient confirmation modal here.
      });


      // REFRESH PATIENT TABLE AFTER ADD / EDIT / DELETE
      // Call after a successful database operation:
      // patientTable.ajax.reload(null, false);

    });

  </script>

</body>

</html>