<?php
include __DIR__ . '/../../connections/connections.php';

// Fetch user types from the database
$sql = "SELECT * FROM z_user_restriction ORDER BY user_type_id ASC";
$result = mysqli_query($conn, $sql);

$userTypes = [];
if ($result) {
  while ($row = mysqli_fetch_assoc($result)) {
    $userTypes[] = $row;
  }
}

if (isset($_POST['user_id'])) {
  $user_id = (int) $_POST['user_id'];
  $sql = "SELECT * FROM z_user WHERE user_id = '$user_id'";
  $result = mysqli_query($conn, $sql);
  if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    ?>

    <div class="modal modal-blur fade" id="editUserModal" tabindex="-1" aria-hidden="true">

      <div class="modal-dialog modal-l modal-dialog-centered">

        <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title">Edit User Details</h5>

            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            </button>
          </div>

          <form id="editUserForm" method="POST">

            <div class="modal-body">

              <input type="hidden" name="user_id" id="edit_user_id"
                value="<?php echo htmlspecialchars($row['user_id']); ?>">


              <div class="mb-3">
                <label class="form-label">
                  First Name
                </label>
                <input type="text" name="first_name" class="form-control" placeholder="E.g. Juan"
                  value="<?php echo htmlspecialchars($row['user_firstname']); ?>" required>
              </div>

              <div class="mb-3">
                <label class="form-label">
                  Last Name
                </label>
                <input type="text" name="last_name" class="form-control" placeholder="E.g. Dela Cruz"
                  value="<?php echo htmlspecialchars($row['user_lastname']); ?>" required>
              </div>

              <div class="mb-3">
                <label class="form-label">
                  Contact No.
                </label>
                <input type="text" name="contact_no" class="form-control" placeholder="E.g. 09123456789"
                  value="<?php echo htmlspecialchars($row['user_contact']); ?>" required>
              </div>

              <div class="mb-3">
                <label class="form-label">
                  Email
                </label>
                <input type="email" name="email" class="form-control" placeholder="E.g. juandelacruz@example.com"
                  value="<?php echo htmlspecialchars($row['user_email']); ?>" required>
              </div>

              <div class="mb-3">
                <label class="form-label">
                  Username
                </label>
                <input type="text" name="username" class="form-control" placeholder="E.g. juandelacruz"
                  value="<?php echo htmlspecialchars($row['user_name']); ?>" required>
              </div>

              <div class="mb-3">
                <label class="form-label" for="edit_user_password">
                  Password
                </label>

                <div class="input-group input-group-flat">
                  <input type="password" name="password" id="edit_user_password" class="form-control"
                    placeholder="Enter new password">

                  <span class="input-group-text">
                    <a href="#" id="toggleEditUserPassword" class="link-secondary" title="Show password">
                      <i class="ti ti-eye" id="editUserPasswordIcon"></i>
                    </a>
                  </span>
                </div>

                <small class="form-hint">
                  Leave this field empty if you don't want to change your password.
                </small>
              </div>


              <div class="mb-3">
                <label class="form-label" for="user_type_id">
                  User Type
                </label>

                <select class="form-select" id="user_type_id" name="user_type_id" required>
                  <option value="">Select User Type</option>

                  <?php
                  foreach ($userTypes as $userType) {
                    $selected = '';

                    if ($row['user_type_id'] == $userType['user_type_id']) {
                      $selected = 'selected="selected"';
                    }
                    ?>
                    <option value="<?php echo htmlspecialchars($userType['user_type_id']); ?>" <?php echo $selected; ?>>
                      <?php echo htmlspecialchars($userType['user_type_name']); ?>
                    </option>
                    <?php
                  }
                  ?>
                </select>
              </div>


            </div>

            <div class="modal-footer">

              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Cancel
              </button>

              <button type="submit" class="btn btn-primary">
                Save Changes
              </button>

            </div>

          </form>

        </div>

      </div>

    </div>

    <?php
  }
}
?>

<script>
  $(document).ready(function () {
    // Initialize Selectize only inside Edit User Modal
    $('#editUserModal select').each(function () {
      // Prevent duplicate initialization
      if (!this.selectize) {
        $(this).selectize({
          sortField: 'text'
        });
      }
    });
  });

  $(document).ready(function () {

    // Toastr Settings
    toastr.options = {
      closeButton: true,
      progressBar: true,
      positionClass: "toast-top-right",
      timeOut: 3000
    };

    // Select All Permissions
    $('#editSelectAllPermissions').on('click', function () {

      $('#editUserForm .permission-checkbox').prop('checked', true);

    });

    // Deselect All Permissions
    $('#editDeselectAllPermissions').on('click', function () {

      $('#editUserForm .permission-checkbox').prop('checked', false);

    });

    // AJAX Edit User Type
    $('#editUserForm').on('submit', function (e) {

      e.preventDefault();

      var form = $(this);
      var btn = $('#editUserModal').find('button[type="submit"]');

      var originalText = btn.html();

      btn.prop('disabled', true);
      btn.html('<i class="ti ti-loader me-2"></i> Updating...');

      $.ajax({
        url: './../controllers/edit_user_process.php',
        type: 'POST',
        data: form.serialize(),
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            toastr.success(response.message);
            // Reset form
            form[0].reset();
            // Close modal
            $('#editUserModal').modal('hide');
            // Refresh users table only

            if ($.fn.DataTable.isDataTable('#usersTable')) {
              $('#usersTable').DataTable().ajax.reload(null, false);
            }
          } else {
            toastr.error(response.message);
          }
        },
        error: function (xhr, textStatus, errorThrown) {
          console.log("AJAX ERROR");
          console.log("HTTP Status:", xhr.status);
          console.log("Text Status:", textStatus);
          console.log("Error:", errorThrown);
          console.log("PHP Response:", xhr.responseText);

          toastr.error(
            xhr.responseText || errorThrown || "Unknown server error."
          );
        },
        complete: function () {

          btn.prop('disabled', false);
          btn.html(originalText);
        }
      });
    });
  });


  // Show / Hide Edit User Password
  $('#toggleEditUserPassword').on('click', function (e) {
    e.preventDefault();

    var passwordInput = $('#edit_user_password');
    var passwordIcon = $('#editUserPasswordIcon');

    if (passwordInput.attr('type') === 'password') {
      passwordInput.attr('type', 'text');
      passwordIcon.removeClass('ti-eye').addClass('ti-eye-off');
      $(this).attr('title', 'Hide password');
    } else {
      passwordInput.attr('type', 'password');
      passwordIcon.removeClass('ti-eye-off').addClass('ti-eye');
      $(this).attr('title', 'Show password');
    }
  });

</script>