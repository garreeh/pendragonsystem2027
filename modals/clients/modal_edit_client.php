<?php
include __DIR__ . '/../../connections/connections.php';



if (isset($_POST['client_id'])) {
  $client_id = (int) $_POST['client_id'];

  /* GET EXISTING CLIENT CONTACT DETAILS */
  $clientContacts = array();

  $contactSql = "
    SELECT
        client_contact_id,
        client_contact_type,
        client_contact_detail
    FROM client_contact
    WHERE client_id = '$client_id'
    ORDER BY client_contact_id ASC
";

  $contactResult = mysqli_query($conn, $contactSql);

  if ($contactResult) {
    while ($contactRow = mysqli_fetch_assoc($contactResult)) {
      $clientContacts[] = $contactRow;
    }
  }

  $sql = "SELECT * FROM client WHERE client_id = '$client_id'";
  $result = mysqli_query($conn, $sql);
  if ($result && mysqli_num_rows($result) > 0) {

    $row = mysqli_fetch_assoc($result);
    $client_locked = isset($row['client_locked']) ? $row['client_locked'] : 'no';

    ?>

    <div class="modal modal-blur fade" id="editClientModal" tabindex="-1" aria-hidden="true">

      <div class="modal-dialog modal-xl modal-dialog-centered">

        <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title">Edit Client Details</h5>

            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            </button>
          </div>

          <form id="editClientForm" method="POST">

            <div class="modal-body">

              <input type="hidden" name="client_id" value="<?php echo htmlspecialchars($row['client_id']); ?>">

              <!-- Main Client Details for client table -->
              <div class="row g-3">


                <!-- LEFT COLUMN -->
                <div class="col-lg-6">

                  <div class="card h-100">

                    <div class="card-header">
                      <h3 class="card-title">
                        Client Information
                      </h3>
                    </div>

                    <div class="card-body">

                      <!-- Client ID -->
                      <div class="mb-3">
                        <label class="form-label">
                          Client ID
                        </label>

                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['client_id']); ?>"
                          readonly>
                      </div>

                      <!-- First Name -->
                      <div class="mb-3">
                        <label class="form-label required">
                          First Name
                        </label>

                        <input type="text" name="client_firstname" class="form-control" placeholder="Enter first name"
                          value="<?php echo htmlspecialchars($row['client_firstname']); ?>" maxlength="100" required>
                      </div>

                      <!-- Last Name -->
                      <div class="mb-3">
                        <label class="form-label required">
                          Last Name
                        </label>

                        <input type="text" name="client_lastname" class="form-control" placeholder="Enter last name"
                          value="<?php echo htmlspecialchars($row['client_lastname']); ?>" maxlength="100" required>
                      </div>

                      <!-- Client Remarks -->
                      <div class="mb-3">
                        <label class="form-label">
                          Client Remarks
                        </label>

                        <textarea name="client_remarks" class="form-control" rows="4" maxlength="2000"
                          placeholder="Enter client remarks"><?php
                          echo htmlspecialchars(
                            isset($row['client_remarks'])
                            ? $row['client_remarks']
                            : ''
                          );
                          ?></textarea>
                      </div>

                      <!-- Account Status -->
                      <div class="mb-3">
                        <label class="form-label">
                          Account Status
                        </label>

                        <div>
                          <?php if ($client_locked == 'yes') { ?>

                            <span class="badge bg-danger-lt">
                              <i class="ti ti-lock me-1"></i>
                              Locked
                            </span>

                          <?php } else { ?>

                            <span class="badge bg-success-lt">
                              <i class="ti ti-lock-open me-1"></i>
                              Active
                            </span>

                          <?php } ?>
                        </div>

                        <small class="form-hint">
                          Use the Lock/Unlock action in the Client Management table
                          to change this status.
                        </small>
                      </div>

                    </div>
                  </div>

                </div>


                <!-- RIGHT COLUMN -->
                <div class="col-lg-6">

                  <div class="card h-100">

                    <div class="card-header">
                      <h3 class="card-title">
                        <i class="ti ti-map-pin me-2"></i>
                        Address Information
                      </h3>
                    </div>

                    <div class="card-body">

                      <!-- Client Whole Address -->
                      <div class="mb-3">
                        <label class="form-label">
                          Whole Address:
                        </label>

                        <textarea name="client_address" class="form-control" rows="3" maxlength="1000"
                          placeholder="Enter complete client address"><?php
                          echo htmlspecialchars(
                            isset($row['client_address'])
                            ? $row['client_address']
                            : ''
                          );
                          ?></textarea>
                      </div>

                      <h4 class="mb-3">Specific Address:</h4>

                      <div class="row g-3">

                        <!-- Street No. -->
                        <div class="col-md-6">
                          <label class="form-label">Street No.</label>
                          <input type="text" name="street_no" class="form-control" placeholder="Street No."
                            value="<?php echo htmlspecialchars($row['client_streetno']); ?>">
                        </div>

                        <!-- Street -->
                        <div class="col-md-6">
                          <label class="form-label">Street</label>
                          <input type="text" name="street" class="form-control" placeholder="Street"
                            value="<?php echo htmlspecialchars($row['client_street']); ?>">
                        </div>

                        <!-- Barangay -->
                        <div class="col-md-6">
                          <label class="form-label">Barangay</label>
                          <input type="text" name="barangay" class="form-control" placeholder="Barangay"
                            value="<?php echo htmlspecialchars($row['client_barangay']); ?>">
                        </div>

                        <!-- District -->
                        <div class="col-md-6">
                          <label class="form-label">District</label>
                          <input type="text" name="district" class="form-control" placeholder="District"
                            value="<?php echo htmlspecialchars($row['client_district']); ?>">
                        </div>

                        <!-- City -->
                        <div class="col-md-4">
                          <label class="form-label">City</label>
                          <input type="text" name="city" class="form-control" placeholder="City"
                            value="<?php echo htmlspecialchars($row['client_city']); ?>">
                        </div>

                        <!-- Province -->
                        <div class="col-md-4">
                          <label class="form-label">Province</label>
                          <input type="text" name="province" class="form-control" placeholder="Province"
                            value="<?php echo htmlspecialchars($row['client_province']); ?>">
                        </div>

                        <!-- Postal Code -->
                        <div class="col-md-4">
                          <label class="form-label">Zip Code</label>
                          <input type="text" name="postal_code" class="form-control" placeholder="Postal Code"
                            value="<?php echo htmlspecialchars($row['client_zip']); ?>">
                        </div>

                      </div>

                    </div>

                  </div>

                </div>


              </div>

              <!-- ADDITIONAL CONTACT DETAILS -->
              <div class="row g-3 mt-1">
                <div class="col-12">

                  <div class="card">

                    <div class="card-header">
                      <h3 class="card-title">
                        <i class="ti ti-address-book me-2"></i>
                        Additional Contact Details
                      </h3>

                      <div class="card-actions">
                        <button type="button" class="btn btn-primary btn-sm" id="btnAddClientContact">
                          <i class="ti ti-plus me-1"></i>
                          Add Contact
                        </button>
                      </div>
                    </div>

                    <div class="card-body">

                      <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0" id="clientContactTable">

                          <thead>
                            <tr>
                              <th style="min-width:150px;">Contact Type</th>
                              <th style="min-width:220px;">Contact Details</th>
                              <th style="width:80px;">Action</th>
                            </tr>
                          </thead>

                          <tbody id="clientContactBody">

                            <?php
                            if (count($clientContacts) > 0) {

                              foreach ($clientContacts as $contact) {
                                ?>

                                <tr class="contact-row">

                                  <td>
                                    <input type="hidden" name="contact_id[]"
                                      value="<?php echo htmlspecialchars($contact['client_contact_id']); ?>">

                                    <select name="contact_type[]" class="form-select contact-type" required>

                                      <option value="mobile" <?php echo ($contact['client_contact_type'] == 'mobile') ? 'selected="selected"' : ''; ?>>Mobile</option>

                                      <option value="telephone" <?php echo ($contact['client_contact_type'] == 'telephone') ? 'selected="selected"' : ''; ?>>Telephone</option>

                                      <option value="email" <?php echo ($contact['client_contact_type'] == 'email') ? 'selected="selected"' : ''; ?>>Email</option>

                                      <option value="facebook" <?php echo ($contact['client_contact_type'] == 'facebook') ? 'selected="selected"' : ''; ?>>Facebook</option>

                                      <option value="website" <?php echo ($contact['client_contact_type'] == 'website') ? 'selected="selected"' : ''; ?>>Website</option>

                                    </select>
                                  </td>

                                  <td>
                                    <input type="text" name="contact_detail[]" class="form-control contact-detail"
                                      value="<?php echo htmlspecialchars($contact['client_contact_detail']); ?>" required>
                                  </td>

                                  <td>
                                    <button type="button" class="btn btn-danger btn-sm btn-remove-contact"
                                      title="Remove contact">
                                      <i class="ti ti-trash"></i>
                                    </button>
                                  </td>

                                </tr>

                                <?php
                              }

                            } else {
                              ?>

                              <tr class="contact-row">

                                <td>
                                  <input type="hidden" name="contact_id[]" value="">

                                  <select name="contact_type[]" class="form-select contact-type" required>
                                    <option value="mobile" selected>Mobile</option>
                                    <option value="telephone">Telephone</option>
                                    <option value="email">Email</option>
                                    <option value="facebook">Facebook</option>
                                    <option value="website">Website</option>
                                  </select>
                                </td>

                                <td>
                                  <input type="text" name="contact_detail[]" class="form-control contact-detail"
                                    placeholder="Enter mobile number" required>
                                </td>

                                <td>
                                  <button type="button" class="btn btn-danger btn-sm btn-remove-contact"
                                    title="Remove contact">
                                    <i class="ti ti-trash"></i>
                                  </button>
                                </td>

                              </tr>

                            <?php } ?>

                          </tbody>

                        </table>
                      </div>

                      <small class="form-hint mt-2">
                        Add multiple contact details. All changes will be saved
                        together when you click Save Changes.
                      </small>

                    </div>
                  </div>

                </div>
              </div>



            </div>

            <div class="modal-footer">

              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Cancel
              </button>

              <button type="submit" id="btnSaveClient" class="btn btn-primary">

                <i class="ti ti-device-floppy me-1"></i>
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

    // Toastr Settings
    toastr.options = {
      closeButton: true,
      progressBar: true,
      positionClass: "toast-top-right",
      timeOut: 3000
    };

    // Select All Permissions
    $('#editSelectAllPermissions').on('click', function () {

      $('#editClientForm .permission-checkbox').prop('checked', true);

    });

    // Deselect All Permissions
    $('#editDeselectAllPermissions').on('click', function () {

      $('#editClientForm .permission-checkbox').prop('checked', false);

    });

    // AJAX Edit User Type
    $('#editClientForm').on('submit', function (e) {

      e.preventDefault();

      var form = $(this);
      var btn = $('#editClientModal').find('button[type="submit"]');

      var originalText = btn.html();

      btn.prop('disabled', true);
      btn.html('<i class="ti ti-loader me-2"></i> Updating...');

      $.ajax({
        url: './../controllers/edit_client_process.php',
        type: 'POST',
        data: form.serialize(),
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            toastr.success(response.message);
            // Reset form
            form[0].reset();
            // Close modal
            $('#editClientModal').modal('hide');
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


  // Client Contact Management
  (function () {

    var formSelector = '#editClientForm';
    var bodySelector = '#clientContactBody';

    /* Configure input based on selected contact type */
    function configureContactInput(row) {

      var type = row.find('.contact-type').val();
      var input = row.find('.contact-detail');

      input.attr('type', 'text');
      input.removeAttr('pattern');
      input.removeAttr('inputmode');
      input.removeAttr('maxlength');

      if (type === 'mobile' || type === 'telephone') {

        input.attr({
          placeholder: type === 'mobile'
            ? 'Enter mobile number'
            : 'Enter telephone number',
          inputmode: 'numeric',
          maxlength: '15',
          pattern: '[0-9]{7,15}'
        });

      } else if (type === 'email') {

        input.attr({
          type: 'email',
          placeholder: 'example@email.com',
          maxlength: '150'
        });

      } else if (type === 'facebook') {

        input.attr({
          placeholder: 'Facebook URL or username',
          maxlength: '255'
        });

      } else if (type === 'website') {

        input.attr({
          type: 'url',
          placeholder: 'https://example.com',
          maxlength: '255'
        });

      }

    }

    /* Configure existing rows */
    $(bodySelector).find('.contact-row').each(function () {
      configureContactInput($(this));
    });

    /* Change contact type */
    $(document)
      .off('change.clientContacts', formSelector + ' .contact-type')
      .on('change.clientContacts', formSelector + ' .contact-type', function () {

        var row = $(this).closest('.contact-row');

        row.find('.contact-detail').val('');

        configureContactInput(row);

      });

    /* Numbers only for Mobile and Telephone */
    $(document)
      .off('input.clientContacts', formSelector + ' .contact-detail')
      .on('input.clientContacts', formSelector + ' .contact-detail', function () {

        var row = $(this).closest('.contact-row');
        var type = row.find('.contact-type').val();

        if (type === 'mobile' || type === 'telephone') {
          this.value = this.value.replace(/[^0-9]/g, '');
        }

      });

    /* ADD CONTACT */
    $(document)
      .off('click.clientContacts', '#btnAddClientContact')
      .on('click.clientContacts', '#btnAddClientContact', function () {

        var newRow = `
                <tr class="contact-row">

                    <td>
                        <input type="hidden" name="contact_id[]" value="">

                        <select name="contact_type[]"
                                class="form-select contact-type"
                                required>
                            <option value="mobile" selected>Mobile</option>
                            <option value="telephone">Telephone</option>
                            <option value="email">Email</option>
                            <option value="facebook">Facebook</option>
                            <option value="website">Website</option>
                        </select>
                    </td>

                    <td>
                        <input type="text"
                               name="contact_detail[]"
                               class="form-control contact-detail"
                               placeholder="Enter mobile number"
                               required>
                    </td>

                    <td>
                        <button type="button"
                                class="btn btn-danger btn-sm btn-remove-contact"
                                title="Remove contact">
                            <i class="ti ti-trash"></i>
                        </button>
                    </td>

                </tr>
            `;

        var row = $(newRow);

        $(bodySelector).append(row);

        configureContactInput(row);

        row.find('.contact-detail').focus();

      });

    /* REMOVE CONTACT */
    $(document)
      .off('click.clientContacts', formSelector + ' .btn-remove-contact')
      .on('click.clientContacts', formSelector + ' .btn-remove-contact', function () {

        $(this).closest('.contact-row').remove();

      });

    /* VALIDATE CONTACT */
    function validateContact(row) {

      var type = row.find('.contact-type').val();
      var value = $.trim(row.find('.contact-detail').val());

      if (value === '') {
        return false;
      }

      if (type === 'mobile' || type === 'telephone') {

        if (!/^[0-9]{7,15}$/.test(value)) {
          toastr.error('Mobile and telephone numbers must contain 7 to 15 digits.');
          return false;
        }

      } else if (type === 'email') {

        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
          toastr.error('Please enter a valid email address.');
          return false;
        }

      } else if (type === 'facebook') {

        var facebookUrl = /^(https?:\/\/)?(www\.)?(facebook\.com|fb\.com)\/[A-Za-z0-9._-]+\/?$/i;
        var facebookUsername = /^@?[A-Za-z0-9._]{3,}$/;

        if (!facebookUrl.test(value) && !facebookUsername.test(value)) {
          toastr.error('Enter a valid Facebook profile URL or username.');
          return false;
        }

      } else if (type === 'website') {

        try {
          var url = new URL(value);

          if (url.protocol !== 'http:' && url.protocol !== 'https:') {
            throw new Error('Invalid URL');
          }

        } catch (error) {
          toastr.error('Enter a valid website URL, including https://.');
          return false;
        }

      } else {

        toastr.error('Invalid contact type.');
        return false;

      }

      return true;

    }

    /* VALIDATE ALL CONTACTS BEFORE MAIN FORM SUBMISSION */
    $(document)
      .off('submit.clientContactsValidation', formSelector)
      .on('submit.clientContactsValidation', formSelector, function (e) {

        var valid = true;

        $(bodySelector).find('.contact-row').each(function () {

          var row = $(this);
          var detail = $.trim(row.find('.contact-detail').val());

          /* Empty rows are ignored and removed */
          if (detail === '') {
            row.remove();
            return true;
          }

          if (!validateContact(row)) {
            valid = false;
            return false;
          }

        });

        if (!valid) {
          e.preventDefault();
          e.stopImmediatePropagation();
          return false;
        }

      });

  })();

</script>