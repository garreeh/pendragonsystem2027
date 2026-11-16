<?php
include __DIR__ . '/../../connections/connections.php';

if (isset($_POST['user_type_id'])) {

    $user_type_id = (int) $_POST['user_type_id'];

    $sql = "SELECT * FROM z_user_restriction
            WHERE user_type_id = '$user_type_id'";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_assoc($result);

        $case_doctor = $row['case_doctor'];
        $billing_discount = $row['billing_discount_percentage'];

        // Permission groups copied from modal_add_user_type
        $permission_groups = array(

            'Client Management' => array(
                'icon' => 'ti-users',
                'permissions' => array(
                    'list_client' => 'List Clients',
                    'client_add' => 'Add Client',
                    'client_edit' => 'Edit Client',
                    'client_view' => 'View Client',
                    'client_delete' => 'Delete Client'
                )
            ),

            'Patient Management' => array(
                'icon' => 'ti-heartbeat',
                'permissions' => array(
                    'list_patient' => 'List Patients',
                    'patient_add' => 'Add Patient',
                    'patient_edit' => 'Edit Patient',
                    'patient_view' => 'View Patient',
                    'patient_delete' => 'Delete Patient'
                )
            ),

            'Case Management' => array(
                'icon' => 'ti-clipboard-list',
                'permissions' => array(
                    'case_add' => 'Add Case',
                    'list_case' => 'List Cases',
                    'case_edit' => 'Edit Case',
                    'case_view' => 'View Case',
                    'case_delete' => 'Delete Case'
                )
            ),

            'User Management' => array(
                'icon' => 'ti-user-cog',
                'permissions' => array(
                    'user_add' => 'Add User',
                    'user_edit' => 'Edit User',
                    'user_view' => 'View User',
                    'user_delete' => 'Delete User',
                    'usertype_add' => 'Add User Type',
                    'usertype_view' => 'View User Type',
                    'usertype_edit' => 'Edit User Type',
                    'usertype_delete' => 'Delete User Type'
                )
            ),

            'Confinement Management' => array(
                'icon' => 'ti-bed',
                'permissions' => array(
                    'confinement_plot_item' => 'Plot Item',
                    'confinement_give_meds' => 'Give Medication',
                    'confinement_client_updates' => 'Client Updates'
                )
            ),

            'Billing Management' => array(
                'icon' => 'ti-receipt',
                'permissions' => array(
                    'billing_view' => 'View Billing',
                    'list_billing' => 'List Billing',
                    'billing_add' => 'Add Billing',
                    'billing_discount_check' => 'Discount Approval'
                )
            ),

            'Inventory Management' => array(
                'icon' => 'ti-package',
                'permissions' => array(
                    'list_item' => 'List Items',
                    'item_add' => 'Add Item',
                    'item_edit' => 'Edit Item',
                    'list_po' => 'List Purchase Orders',
                    'po_add' => 'Add Purchase Order',
                    'po_view' => 'View Purchase Order',
                    'po_edit' => 'Edit Purchase Order',
                    'po_delete' => 'Delete Purchase Order'
                )
            ),

            'Voucher Management' => array(
                'icon' => 'ti-ticket',
                'permissions' => array(
                    'list_voucher' => 'List Vouchers',
                    'voucher_add' => 'Add Voucher',
                    'voucher_view' => 'View Voucher',
                    'voucher_edit' => 'Edit Voucher'
                )
            ),

            'Laboratory Management' => array(
                'icon' => 'ti-microscope',
                'permissions' => array(
                    'list_lab' => 'List Laboratory Records',
                    'lab_add' => 'Add Laboratory Record',
                    'lab_edit' => 'Edit Laboratory Record',
                    'lab_delete' => 'Delete Laboratory Record',
                    'serum_chem_view' => 'View Serum Chemistry'
                )
            ),

            'Clinic Services' => array(
                'icon' => 'ti-stethoscope',
                'permissions' => array(
                    'list_clinic_service' => 'List Clinic Services',
                    'add_clinic_service' => 'Add Clinic Service',
                    'edit_clinic_service' => 'Edit Clinic Service',
                    'delete_clinic_service' => 'Delete Clinic Service'
                )
            ),

            'Supplier Management' => array(
                'icon' => 'ti-truck-delivery',
                'permissions' => array(
                    'list_supplier' => 'List Suppliers',
                    'add_supplier' => 'Add Supplier',
                    'edit_supplier' => 'Edit Supplier',
                    'delete_supplier' => 'Delete Supplier'
                )
            ),

            'Efficacy Management' => array(
                'icon' => 'ti-chart-line',
                'permissions' => array(
                    'list_efficacy' => 'List Efficacy Records',
                    'add_efficacy' => 'Add Efficacy Record',
                    'edit_efficacy' => 'Edit Efficacy Record',
                    'delete_efficacy' => 'Delete Efficacy Record'
                )
            ),

            'Vaccine Management' => array(
                'icon' => 'ti-vaccine',
                'permissions' => array(
                    'list_vaccine' => 'List Vaccines',
                    'add_vaccine' => 'Add Vaccine',
                    'edit_vaccine' => 'Edit Vaccine',
                    'delete_vaccine' => 'Delete Vaccine'
                )
            ),

            'Diagnosis Management' => array(
                'icon' => 'ti-report-medical',
                'permissions' => array(
                    'list_diagnosis' => 'List Diagnoses',
                    'add_diagnosis' => 'Add Diagnosis',
                    'edit_diagnosis' => 'Edit Diagnosis',
                    'delete_diagnosis' => 'Delete Diagnosis'
                )
            ),

            'Species Management' => array(
                'icon' => 'ti-paw',
                'permissions' => array(
                    'list_species' => 'List Species',
                    'add_species' => 'Add Species',
                    'edit_species' => 'Edit Species',
                    'delete_species' => 'Delete Species'
                )
            ),

            'Breed Management' => array(
                'icon' => 'ti-dog',
                'permissions' => array(
                    'list_breed' => 'List Breeds',
                    'add_breed' => 'Add Breed',
                    'edit_breed' => 'Edit Breed',
                    'delete_breed' => 'Delete Breed'
                )
            ),

            'Category Management' => array(
                'icon' => 'ti-category',
                'permissions' => array(
                    'list_category' => 'List Categories',
                    'add_category' => 'Add Category',
                    'edit_category' => 'Edit Category',
                    'delete_category' => 'Delete Category'
                )
            ),

            'Appointment Services' => array(
                'icon' => 'ti-calendar-check',
                'permissions' => array(
                    'list_appointment_service' => 'List Appointment Services',
                    'add_appointment_service' => 'Add Appointment Service',
                    'delete_appointment_service' => 'Delete Appointment Service'
                )
            ),

            'Headline Management' => array(
                'icon' => 'ti-news',
                'permissions' => array(
                    'list_headline' => 'List Headlines',
                    'add_headline' => 'Add Headline',
                    'edit_headline' => 'Edit Headline',
                    'delete_headline' => 'Delete Headline'
                )
            ),

            'Channel Management' => array(
                'icon' => 'ti-broadcast',
                'permissions' => array(
                    'list_channel' => 'List Channels',
                    'add_channel' => 'Add Channel',
                    'edit_channel' => 'Edit Channel',
                    'delete_channel' => 'Delete Channel'
                )
            ),

            'Reports & Analytics' => array(
                'icon' => 'ti-chart-bar',
                'permissions' => array(
                    'user_stat_report' => 'User Statistics Report',
                    'patient_deceased_report' => 'Patient Deceased Report',
                    'confinement_record_report' => 'Confinement Record Report',
                    'case_log_report' => 'Case Log Report',
                    'case_diagnosis_report' => 'Case Diagnosis Report',
                    'case_followup_report' => 'Case Follow-up Report',
                    'vaccination_exp_report' => 'Vaccination Expiration Report',
                    'registration_report' => 'Registration Report',
                    'reorder_level_report' => 'Reorder Level Report',
                    'sales_breakdown_report' => 'Sales Breakdown Report',
                    'sales_turnover_report' => 'Sales Turnover Report',
                    'clinic_service_report' => 'Clinic Service Report',
                    'clinic_inventory_report' => 'Clinic Inventory Report',
                    'lab_report' => 'Laboratory Report',
                    'lab_inventory_report' => 'Laboratory Inventory Report'
                )
            ),

            'Other Permissions' => array(
                'icon' => 'ti-settings',
                'permissions' => array(
                    'delete_history_view' => 'View Deleted History',
                    'sms_sending_view' => 'SMS Sending'
                )
            )

        );
        ?>

        <div class="modal modal-blur fade" id="editUserTypeModal" tabindex="-1" aria-hidden="true">

            <div class="modal-dialog modal-xl modal-dialog-centered">

                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit User Type</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>

                    <form id="editUserTypeForm" method="POST">

                        <div class="modal-body">

                            <input type="hidden" name="user_type_id" id="edit_user_type_id"
                                value="<?php echo htmlspecialchars($row['user_type_id']); ?>">

                            <!-- User Type Name -->
                            <div class="mb-4">

                                <label class="form-label">User Type Name</label>

                                <input type="text" class="form-control" name="user_type_name" id="edit_user_type_name"
                                    placeholder="E.g. Administrator, Veterinarian, Receptionist"
                                    value="<?php echo htmlspecialchars($row['user_type_name']); ?>" required>

                            </div>

                            <div class="row">

                                <!-- Case Doctor -->
                                <div class="col-md-6">

                                    <div class="mb-3">

                                        <label class="form-label">Case Doctor</label>

                                        <select class="form-select" name="case_doctor" id="edit_case_doctor">

                                            <option value="enabled" <?php echo ($case_doctor == 'enabled') ? 'selected' : ''; ?>>
                                                Enabled
                                            </option>

                                            <option value="disabled" <?php echo ($case_doctor == 'disabled') ? 'selected' : ''; ?>>
                                                Disabled
                                            </option>

                                        </select>

                                        <small class="form-hint">
                                            Enable or disable case doctor access for this user type.
                                        </small>

                                    </div>

                                </div>

                                <!-- Billing Discount -->
                                <div class="col-md-6">

                                    <div class="mb-3">

                                        <label class="form-label">Discount (%)</label>

                                        <div class="input-group">

                                            <input type="text" class="form-control" name="billing_discount_percentage"
                                                id="edit_billing_discount_percentage"
                                                value="<?php echo htmlspecialchars($billing_discount); ?>" placeholder="E.g. 10"
                                                maxlength="3" inputmode="numeric" oninput="
                                            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3);

                                            if (this.value !== '' && parseInt(this.value, 10) > 100) {
                                                this.value = '100';
                                            }
                                        " pattern="^(100|[1-9][0-9]?)$"
                                                title="Enter a discount percentage between 1 and 100." required>

                                            <span class="input-group-text">%</span>

                                        </div>

                                        <small class="form-hint">
                                            Enter a discount percentage between 1% and 100%.
                                        </small>

                                    </div>

                                </div>

                            </div>

                            <!-- User Permissions -->
                            <div class="d-flex justify-content-between align-items-center mb-3">

                                <h4 class="mb-0">
                                    <i class="ti ti-shield-lock me-2"></i>
                                    User Permissions
                                </h4>

                                <div class="d-flex gap-2">

                                    <button type="button" class="btn btn-sm btn-primary" id="editSelectAllPermissions">
                                        Select All
                                    </button>

                                    <button type="button" class="btn btn-sm btn-outline-secondary"
                                        id="editDeselectAllPermissions">
                                        Deselect All
                                    </button>

                                </div>

                            </div>

                            <div class="row">

                                <?php foreach ($permission_groups as $group_name => $group) { ?>

                                    <div class="col-md-6 mb-3">

                                        <div class="card card-gradient h-100">

                                            <div class="card-header">

                                                <h4 class="card-title mb-0">

                                                    <i class="ti <?php echo $group['icon']; ?> me-2"></i>

                                                    <?php echo htmlspecialchars($group_name); ?>

                                                </h4>

                                            </div>

                                            <div class="card-body">

                                                <?php foreach ($group['permissions'] as $permission_name => $permission_label) {

                                                    $checked = (
                                                        isset($row[$permission_name]) &&
                                                        $row[$permission_name] == 1
                                                    ) ? 'checked' : '';

                                                    ?>

                                                    <div class="form-check mb-2">

                                                        <input class="form-check-input permission-checkbox" type="checkbox"
                                                            name="<?php echo $permission_name; ?>" value="1"
                                                            id="edit_<?php echo $permission_name; ?>" <?php echo $checked; ?>>

                                                        <label class="form-check-label" for="edit_<?php echo $permission_name; ?>">

                                                            <?php echo htmlspecialchars($permission_label); ?>

                                                        </label>

                                                    </div>

                                                <?php } ?>

                                            </div>

                                        </div>

                                    </div>

                                <?php } ?>

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

        // Toastr Settings
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 3000
        };

        // Select All Permissions
        $('#editSelectAllPermissions').on('click', function () {

            $('#editUserTypeForm .permission-checkbox').prop('checked', true);

        });

        // Deselect All Permissions
        $('#editDeselectAllPermissions').on('click', function () {

            $('#editUserTypeForm .permission-checkbox').prop('checked', false);

        });

        // AJAX Edit User Type
        $('#editUserTypeForm').on('submit', function (e) {

            e.preventDefault();

            var form = $(this);
            var btn = $('#editUserTypeModal').find('button[type="submit"]');

            var originalText = btn.html();

            btn.prop('disabled', true);
            btn.html('<i class="ti ti-loader me-2"></i> Updating...');

            $.ajax({

                url: './../controllers/edit_user_type_process.php',

                type: 'POST',

                data: form.serialize(),

                dataType: 'json',

                success: function (response) {

                    if (response.success) {

                        toastr.success(response.message);

                        // Reset form
                        form[0].reset();

                        // Close modal
                        $('#editUserTypeModal').modal('hide');

                        // Refresh users table only
                        if ($.fn.DataTable.isDataTable('#usersTypeTable')) {
                            $('#usersTypeTable').DataTable().ajax.reload(null, false);
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

</script>