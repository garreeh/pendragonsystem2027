<?php
include __DIR__ . '/../../connections/connections.php';

if (isset($_POST['client_id'])) {

  $client_id = (int) $_POST['client_id'];

  $query = "SELECT * FROM client WHERE client_id = '$client_id' LIMIT 1";
  $result = mysqli_query($conn, $query);

  if ($result && mysqli_num_rows($result) > 0) {

    $row = mysqli_fetch_assoc($result);

    $client_locked = isset($row['client_locked']) ? $row['client_locked'] : 'no';

    if ($client_locked == 'no') {
      $new_status = 'yes';
      $modal_title = 'Lock Client Account';
      $modal_message = 'Are you sure you want to lock this client account? The client will no longer be able to log in.';
      $button_text = 'Yes, Lock Account';
      $button_class = 'btn-danger';
      $icon = 'ti-lock';
    } else {
      $new_status = 'no';
      $modal_title = 'Unlock Client Account';
      $modal_message = 'Are you sure you want to unlock this client account? The client will be able to log in again.';
      $button_text = 'Yes, Unlock Account';
      $button_class = 'btn-success';
      $icon = 'ti-lock-open';
    }
    ?>

    <div class="modal modal-blur fade" id="lockClientModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title">
              <?php echo htmlspecialchars($modal_title); ?>
            </h5>

            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <form id="changeClientStatusForm" method="POST">

            <div class="modal-body">

              <input type="hidden" name="client_id" value="<?php echo htmlspecialchars($row['client_id']); ?>">

              <input type="hidden" name="client_locked" value="<?php echo htmlspecialchars($new_status); ?>">

              <div class="text-center">

                <span class="avatar avatar-xl mb-3
                            <?php echo ($new_status == 'yes') ? 'bg-danger-lt' : 'bg-success-lt'; ?>">
                  <i class="ti <?php echo $icon; ?> fs-1"></i>
                </span>

                <h3>
                  <?php echo htmlspecialchars($row['client_firstname'] . ' ' . $row['client_lastname']); ?>
                </h3>

                <p class="text-secondary mb-0">
                  <?php echo htmlspecialchars($modal_message); ?>
                </p>

              </div>

            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Cancel
              </button>

              <button type="submit" id="btnConfirmClientStatus" class="btn <?php echo $button_class; ?>">

                <i class="ti <?php echo $icon; ?> me-1"></i>
                <?php echo htmlspecialchars($button_text); ?>

              </button>
            </div>

          </form>

        </div>
      </div>
    </div>

    <?php
  } else {
    echo '<div class="alert alert-danger">User account not found.</div>';
  }
}
?>

<script>
  toastr.options = {
    closeButton: true,
    progressBar: true,
    positionClass: "toast-top-right",
    timeOut: 3000
  };

  // LOCK / UNLOCK CLIENT ACCOUNT - SUBMIT
  $(document)
    .off('submit.clientStatus', '#changeClientStatusForm')
    .on('submit.clientStatus', '#changeClientStatusForm', function (e) {

      e.preventDefault();

      var form = $(this);
      var submitBtn = form.find('#btnConfirmClientStatus');
      var originalText = submitBtn.html();

      submitBtn.prop('disabled', true);
      submitBtn.html('<span class="spinner-border spinner-border-sm me-1"></span> Processing...');

      $.ajax({
        url: './../controllers/update_client_status_process.php',
        type: 'POST',
        data: form.serialize(),
        dataType: 'json',

        success: function (response) {

          if (response.success) {

            var clientStatus = form.find('input[name="client_locked"]').val();

            if (clientStatus == 'yes') {
              // Red notification when locking
              toastr.error(response.message);
            } else {
              // Green notification when unlocking
              toastr.success(response.message);
            }

            $('#lockClientModal').modal('hide');

            // Refresh clients table only
            if ($.fn.DataTable.isDataTable('#clientTable')) {
              $('#clientTable').DataTable().ajax.reload(null, false);
            }

          } else {

            toastr.error(response.message);

          }
        },

        error: function (xhr) {

          console.log('AJAX Error:', xhr.status);
          console.log(xhr.responseText);

          toastr.error('Unable to update client account status.');

        },

        complete: function () {

          submitBtn.prop('disabled', false);
          submitBtn.html(originalText);

        }
      });

    });


</script>