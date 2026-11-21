<?php
include __DIR__ . '/../../connections/connections.php';
?>

<!-- ADD CLIENT MODAL -->
<div class="modal modal-blur card-gradient fade" id="addPatientModal" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          Add New Patient

        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal">
        </button>
      </div>
      <div class="modal-body">
        <form id="addClientForm" method="POST">

          <div class="modal-body">

            <!-- MAIN CLIENT DETAILS -->
            <div class="row g-3">

              <!-- LEFT COLUMN -->
              <div class="col-lg-6">
                <div class="card h-100">

                  <div class="card-header">
                    <h3 class="card-title">
                      <i class="ti ti-user me-2"></i>
                      Client Information
                    </h3>
                  </div>

                  <div class="card-body">

                    <div class="mb-3">
                      <label class="form-label required">First Name</label>
                      <input type="text" name="client_firstname" class="form-control" placeholder="Enter first name"
                        maxlength="100" required>
                    </div>

                    <div class="mb-3">
                      <label class="form-label required">Last Name</label>
                      <input type="text" name="client_lastname" class="form-control" placeholder="Enter last name"
                        maxlength="100" required>
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Client Remarks</label>
                      <textarea name="client_remarks" class="form-control" rows="4" maxlength="2000"
                        placeholder="Enter client remarks"></textarea>
                    </div>

                    <div class="alert alert-info mb-0">
                      <i class="ti ti-info-circle me-1"></i>
                      The client account will be created with an
                      <strong>Active</strong> status.
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

                    <div class="mb-3">
                      <label class="form-label">Whole Address</label>
                      <textarea name="client_address" class="form-control" rows="3" maxlength="1000"
                        placeholder="Enter complete client address"></textarea>
                    </div>

                    <h4 class="mb-3">Specific Address:</h4>

                    <div class="row g-3">

                      <div class="col-md-6">
                        <label class="form-label">Street No.</label>
                        <input type="text" name="street_no" class="form-control" placeholder="Street No."
                          maxlength="100">
                      </div>

                      <div class="col-md-6">
                        <label class="form-label">Street</label>
                        <input type="text" name="street" class="form-control" placeholder="Street" maxlength="150">
                      </div>

                      <div class="col-md-6">
                        <label class="form-label">Barangay</label>
                        <input type="text" name="barangay" class="form-control" placeholder="Barangay" maxlength="150">
                      </div>

                      <div class="col-md-6">
                        <label class="form-label">District</label>
                        <input type="text" name="district" class="form-control" placeholder="District" maxlength="150">
                      </div>

                      <div class="col-md-4">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control" placeholder="City" maxlength="150">
                      </div>

                      <div class="col-md-4">
                        <label class="form-label">Province</label>
                        <input type="text" name="province" class="form-control" placeholder="Province" maxlength="150">
                      </div>

                      <div class="col-md-4">
                        <label class="form-label">Zip Code</label>
                        <input type="text" name="postal_code" class="form-control" placeholder="Zip Code"
                          maxlength="20">
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
                      <button type="button" class="btn btn-primary btn-sm" id="btnAddNewClientContact">
                        <i class="ti ti-plus me-1"></i>
                        Add Contact
                      </button>
                    </div>
                  </div>

                  <div class="card-body">

                    <div class="table-responsive">
                      <table class="table table-bordered align-middle mb-0" id="addClientContactTable">

                        <thead>
                          <tr>
                            <th style="min-width:150px;">Contact Type</th>
                            <th style="min-width:220px;">Contact Details</th>
                            <th style="width:80px;">Action</th>
                          </tr>
                        </thead>

                        <tbody id="addClientContactBody">

                          <tr class="new-contact-row">
                            <td>
                              <select name="contact_type[]" class="form-select new-contact-type">
                                <option value="mobile" selected>Mobile</option>
                                <option value="telephone">Telephone</option>
                                <option value="email">Email</option>
                                <option value="facebook">Facebook</option>
                                <option value="website">Website</option>
                              </select>
                            </td>

                            <td>
                              <input type="text" name="contact_detail[]" class="form-control new-contact-detail"
                                placeholder="Enter mobile number">
                            </td>

                            <td>
                              <button type="button" class="btn btn-danger btn-sm btn-remove-new-contact"
                                title="Remove contact">
                                <i class="ti ti-trash"></i>
                              </button>
                            </td>
                          </tr>

                        </tbody>

                      </table>
                    </div>

                    <small class="form-hint mt-2">
                      Add multiple contact details. All contacts will be saved
                      together with the new client.
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

            <button type="submit" id="btnSaveNewClient" class="btn btn-primary">
              <i class="ti ti-device-floppy me-1"></i>
              Save Client
            </button>

          </div>

        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {

    // Toastr settings
    toastr.options = {
      closeButton: true,
      progressBar: true,
      positionClass: "toast-top-right",
      timeOut: 3000
    };

    var addContactBody = '#addClientContactBody';
    var addClientForm = '#addClientForm';

    // Configure contact input based on selected type
    function configureNewContactInput(row) {

      var type = row.find('.new-contact-type').val();
      var input = row.find('.new-contact-detail');

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

    // Configure initial row
    $(addContactBody).find('.new-contact-row').each(function () {
      configureNewContactInput($(this));
    });

    // Change contact type
    $(document)
      .off('change.addNewClientContacts', addClientForm + ' .new-contact-type')
      .on('change.addNewClientContacts', addClientForm + ' .new-contact-type', function () {

        var row = $(this).closest('.new-contact-row');

        row.find('.new-contact-detail').val('');
        configureNewContactInput(row);
      });

    // Numbers only for mobile and telephone
    $(document)
      .off('input.addNewClientContacts', addClientForm + ' .new-contact-detail')
      .on('input.addNewClientContacts', addClientForm + ' .new-contact-detail', function () {

        var row = $(this).closest('.new-contact-row');
        var type = row.find('.new-contact-type').val();

        if (type === 'mobile' || type === 'telephone') {
          this.value = this.value.replace(/[^0-9]/g, '');
        }
      });

    // Add contact row
    $(document)
      .off('click.addNewClientContacts', '#btnAddNewClientContact')
      .on('click.addNewClientContacts', '#btnAddNewClientContact', function () {

        var newRow = `
                <tr class="new-contact-row">

                    <td>
                        <select name="contact_type[]"
                                class="form-select new-contact-type">
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
                               class="form-control new-contact-detail"
                               placeholder="Enter mobile number">
                    </td>

                    <td>
                        <button type="button"
                                class="btn btn-danger btn-sm btn-remove-new-contact"
                                title="Remove contact">
                            <i class="ti ti-trash"></i>
                        </button>
                    </td>

                </tr>
            `;

        var row = $(newRow);

        $(addContactBody).append(row);

        configureNewContactInput(row);

        row.find('.new-contact-detail').focus();
      });

    // Remove contact row
    $(document)
      .off('click.addNewClientContacts', addClientForm + ' .btn-remove-new-contact')
      .on('click.addNewClientContacts', addClientForm + ' .btn-remove-new-contact', function () {

        $(this).closest('.new-contact-row').remove();
      });

    // Validate contact details
    function validateNewContact(row) {

      var type = row.find('.new-contact-type').val();
      var value = String(row.find('.new-contact-detail').val() || '').trim();

      if (value === '') {
        return true;
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

    // Submit Add Client form
    $(document)
      .off('submit.addNewClient', addClientForm)
      .on('submit.addNewClient', addClientForm, function (e) {

        e.preventDefault();

        var form = $(this);
        var valid = true;

        // Validate contact rows and remove empty rows
        $(addContactBody).find('.new-contact-row').each(function () {

          var row = $(this);
          var detail = String(row.find('.new-contact-detail').val() || '').trim();

          if (detail === '') {
            row.remove();
            return true;
          }

          if (!validateNewContact(row)) {
            valid = false;
            return false;
          }
        });

        if (!valid) {
          return false;
        }

        var btn = $('#btnSaveNewClient');
        var originalText = btn.html();

        btn.prop('disabled', true);
        btn.html('<i class="ti ti-loader me-2"></i> Saving...');

        $.ajax({
          url: './../controllers/add_client_process.php',
          type: 'POST',
          data: form.serialize(),
          dataType: 'json',

          success: function (response) {

            if (response.success) {

              toastr.success(response.message);

              form[0].reset();

              // Restore one default contact row
              $(addContactBody).html(`
                            <tr class="new-contact-row">
                                <td>
                                    <select name="contact_type[]"
                                            class="form-select new-contact-type">
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
                                           class="form-control new-contact-detail"
                                           placeholder="Enter mobile number">
                                </td>
                                <td>
                                    <button type="button"
                                            class="btn btn-danger btn-sm btn-remove-new-contact"
                                            title="Remove contact">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `);

              $(addContactBody).find('.new-contact-row').each(function () {
                configureNewContactInput($(this));
              });

              // Close modal
              $('#addPatientModal').modal('hide');

              // Refresh Client DataTable
              if ($.fn.DataTable.isDataTable('#clientTable')) {
                $('#clientTable').DataTable().ajax.reload(null, false);
              }

            } else {

              toastr.error(response.message);
            }
          },

          error: function (xhr, textStatus, errorThrown) {

            console.log('AJAX ERROR');
            console.log('HTTP Status:', xhr.status);
            console.log('Text Status:', textStatus);
            console.log('Error:', errorThrown);
            console.log('PHP Response:', xhr.responseText);

            toastr.error(
              'Unable to save client. Please check the server response.'
            );
          },

          complete: function () {

            btn.prop('disabled', false);
            btn.html(originalText);
          }
        });
      });

  });
</script>