<?php
include './../connections/connections.php';

// Fetch user types from the database
$sql = "SELECT * FROM z_user_restriction ORDER BY user_type_id ASC";
$result = mysqli_query($conn, $sql);

$userTypes = [];
if ($result) {
  while ($row = mysqli_fetch_assoc($result)) {
    $userTypes[] = $row;
  }
}
?>

<!-- ADD USER MODAL -->
<div class="modal modal-blur card-gradient fade" id="addUserModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          Add New User
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal">
        </button>
      </div>
      <div class="modal-body">
        <form id="addUserForm">
          <div class="mb-3">
            <label class="form-label">
              First Name
            </label>
            <input type="text" name="first_name" class="form-control" placeholder="E.g. Juan" required>
          </div>

          <div class="mb-3">
            <label class="form-label">
              Last Name
            </label>
            <input type="text" name="last_name" class="form-control" placeholder="E.g. Dela Cruz" required>
          </div>

          <div class="mb-3">
            <label class="form-label">
              Contact No.
            </label>
            <input type="text" name="contact_no" class="form-control" placeholder="E.g. 09123456789" required>
          </div>

          <div class="mb-3">
            <label class="form-label">
              Email
            </label>
            <input type="email" name="email" class="form-control" placeholder="E.g. juandelacruz@example.com" required>
          </div>

          <div class="mb-3">
            <label class="form-label">
              Username
            </label>
            <input type="text" name="username" class="form-control" placeholder="E.g. juandelacruz" required>
          </div>

          <div class="mb-3">
            <label class="form-label" for="add_user_password">
              Password
            </label>

            <div class="input-group input-group-flat">
              <input type="password" id="add_user_password" name="password" class="form-control"
                placeholder="Enter password" required>

              <span class="input-group-text">
                <a href="#" class="link-secondary" id="toggleAddUserPassword" title="Show password"
                  data-bs-toggle="tooltip">

                  <i class="ti ti-eye" id="addUserPasswordIcon"></i>
                </a>
              </span>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label" for="user_type_id">
              User Type
            </label>

            <select class="form-select" id="user_type_id" name="user_type_id" required>
              <option value="">Select User Type</option>

              <?php foreach ($userTypes as $userType): ?>
                <option value="<?php echo htmlspecialchars($userType['user_type_id']); ?>">
                  <?php echo htmlspecialchars($userType['user_type_name']); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">User Status</label>
            <select class="form-select" name="user_status" required>
              <option value="enabled" selected>Active</option>
              <option value="disabled">Inactive / Lock</option>
            </select>
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
          Cancel
        </button>
        <button type="submit" form="addUserForm" class="btn btn-primary">
          <i class="ti ti-device-floppy me-1"></i>
          Save User
        </button>
      </div>
    </div>
  </div>
</div>


<script>

  $(document).ready(function () {

    toastr.options = {
      closeButton: true,
      progressBar: true,
      positionClass: "toast-top-right",
      timeOut: 3000
    };

    $('#addUserForm').on('submit', function (e) {
      e.preventDefault();

      const btn = $('#addUserModal').find('button[type="submit"]');
      const originalText = btn.html();

      btn.prop('disabled', true);
      btn.html('<i class="ti ti-loader me-2"></i> Saving...');

      $.ajax({
        url: './../controllers/add_user_process.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',

        success: function (response) {

          if (response.success) {

            toastr.success(response.message);

            // Reset form
            $('#addUserForm')[0].reset();

            // Close modal
            $('#addUserModal').modal('hide');

            // Refresh table only
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

  // Show / Hide Password
  $('#toggleAddUserPassword').on('click', function (e) {
    e.preventDefault();

    var passwordInput = $('#add_user_password');
    var passwordIcon = $('#addUserPasswordIcon');

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