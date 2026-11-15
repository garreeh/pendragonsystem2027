<?php
include __DIR__ . '/../../connections/connections.php';

if (isset($_POST['user_id'])) {

  $user_id = (int) $_POST['user_id'];

  $query = "SELECT * FROM z_user WHERE user_id = '$user_id' LIMIT 1";
  $result = mysqli_query($conn, $query);

  if ($result && mysqli_num_rows($result) > 0) {

    $row = mysqli_fetch_assoc($result);

    $user_status = isset($row['user_status']) ? $row['user_status'] : 'enabled';

    if ($user_status == 'enabled') {
      $new_status = 'disabled';
      $modal_title = 'Lock User Account';
      $modal_message = 'Are you sure you want to lock this user account? The user will no longer be able to log in.';
      $button_text = 'Yes, Lock Account';
      $button_class = 'btn-danger';
      $icon = 'ti-lock';
    } else {
      $new_status = 'enabled';
      $modal_title = 'Unlock User Account';
      $modal_message = 'Are you sure you want to unlock this user account? The user will be able to log in again.';
      $button_text = 'Yes, Unlock Account';
      $button_class = 'btn-success';
      $icon = 'ti-lock-open';
    }
    ?>

    <div class="modal modal-blur fade" id="lockUserModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title">
              <?php echo htmlspecialchars($modal_title); ?>
            </h5>

            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <form id="changeUserStatusForm" method="POST">

            <div class="modal-body">

              <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row['user_id']); ?>">

              <input type="hidden" name="user_status" value="<?php echo htmlspecialchars($new_status); ?>">

              <div class="text-center">

                <span class="avatar avatar-xl mb-3
                            <?php echo ($new_status == 'disabled') ? 'bg-danger-lt' : 'bg-success-lt'; ?>">
                  <i class="ti <?php echo $icon; ?> fs-1"></i>
                </span>

                <h3>
                  <?php echo htmlspecialchars($row['user_firstname'] . ' ' . $row['user_lastname']); ?>
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

              <button type="submit" id="btnConfirmUserStatus" class="btn <?php echo $button_class; ?>">

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
  // LOCK / UNLOCK USER ACCOUNT - SUBMIT
  $(document)
    .off('submit.userStatus', '#changeUserStatusForm')
    .on('submit.userStatus', '#changeUserStatusForm', function (e) {

      e.preventDefault();

      var form = $(this);
      var submitBtn = form.find('#btnConfirmUserStatus');
      var originalText = submitBtn.html();

      submitBtn.prop('disabled', true);
      submitBtn.html('<span class="spinner-border spinner-border-sm me-1"></span> Processing...');

      $.ajax({
        url: './../controllers/update_user_status_process.php',
        type: 'POST',
        data: form.serialize(),
        dataType: 'json',

        success: function (response) {

          if (response.success) {

            var userStatus = form.find('input[name="user_status"]').val();

            if (userStatus == 'disabled') {
              // Red notification when locking
              toastr.error(response.message);
            } else {
              // Green notification when unlocking
              toastr.success(response.message);
            }

            $('#lockUserModal').modal('hide');

            // Refresh users table only
            $('#usersTable').load(
              window.location.href + ' #usersTable',
              function () {
                console.log('Users table updated successfully.');
              }
            );

          } else {

            toastr.error(response.message);

          }
        },

        error: function (xhr) {

          console.log('AJAX Error:', xhr.status);
          console.log(xhr.responseText);

          toastr.error('Unable to update user account status.');

        },

        complete: function () {

          submitBtn.prop('disabled', false);
          submitBtn.html(originalText);

        }
      });

    });


</script>