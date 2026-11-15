<!-- ADD USER MODAL -->
<div class="modal modal-blur fade" id="addUserModal" tabindex="-1">
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
              Full Name
            </label>
            <input type="text" name="full_name" class="form-control" placeholder="E.g. Juan Dela Cruz" required>
          </div>
          <div class="mb-3">
            <label class="form-label">
              Username
            </label>
            <input type="text" name="username" class="form-control" placeholder="E.g. juandelacruz" required>
          </div>
          <div class="mb-3">
            <label class="form-label">
              Email
            </label>
            <input type="email" name="email" class="form-control" placeholder="E.g. juandelacruz@example.com" required>
          </div>
          <div class="mb-3">
            <label class="form-label">
              Password
            </label>
            <input type="password" name="password" class="form-control" placeholder="E.g. ********" required>
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