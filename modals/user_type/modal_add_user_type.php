<div class="modal modal-blur fade" id="addUserTypeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Add New User Type</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="addUserTypeForm" method="POST" enctype="multipart/form-data">

        <div class="modal-body">


          <div class="mb-4">
            <label class="form-label">User Type Name</label>
            <input type="text" class="form-control" name="user_type_name"
              placeholder="E.g. Administrator, Veterinarian, Receptionist" required>
          </div>

          <div class="row">
            <!-- Case Doctor -->
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Case Doctor</label>
                <select class="form-select" name="case_doctor">
                  <option value="enabled" selected>Enabled</option>
                  <option value="disabled">Disabled</option>
                </select>
                <small class="form-hint">
                  Enable or disable case doctor access for this user type.
                </small>
              </div>
            </div>

            <!-- Discount -->

            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Discount (%)</label>
                <div class="input-group">
                  <input type="text" class="form-control" name="billing_discount_percentage" placeholder="E.g. 10"
                    maxlength="3" inputmode="numeric" oninput="
          this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3);
          if (this.value !== '' && parseInt(this.value, 10) > 100) {
            this.value = '100';
          }
        " pattern="^(100|[1-9][0-9]?)$" title="Enter a discount percentage between 1 and 100." required>
                  <span class="input-group-text">%</span>
                </div>
                <small class="form-hint">
                  Enter a discount percentage between 1% and 100%.
                </small>
              </div>
            </div>

          </div>


          <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0"><i class="ti ti-shield-lock me-2"></i>User Permissions</h4>

            <div class="d-flex gap-2">
              <button type="button" class="btn btn-sm btn-primary"
                onclick="$('.permission-checkbox').prop('checked', true)">
                Select All
              </button>

              <button type="button" class="btn btn-sm btn-outline-secondary"
                onclick="$('.permission-checkbox').prop('checked', false)">
                Deselect All
              </button>
            </div>
          </div>

          <div class="row">

            <!-- Client Management -->
            <div class="col-md-6 mb-3">
              <div class="card card-gradient h-100">
                <div class="card-header">
                  <h4 class="card-title mb-0">
                    <i class="ti ti-users me-2"></i>
                    Client Management
                  </h4>
                </div>
                <div class="card-body">
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="list_client" value="1"
                      id="list_client">
                    <label class="form-check-label" for="list_client">List Clients</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="client_add" value="1"
                      id="client_add">
                    <label class="form-check-label" for="client_add">Add Client</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="client_edit" value="1"
                      id="client_edit">
                    <label class="form-check-label" for="client_edit">Edit Client</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="client_view" value="1"
                      id="client_view">
                    <label class="form-check-label" for="client_view">View Client</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="client_delete" value="1"
                      id="client_delete">
                    <label class="form-check-label" for="client_delete">Delete Client</label>
                  </div>
                </div>
              </div>
            </div>

            <!-- Patient Management -->
            <div class="col-md-6 mb-3">
              <div class="card card-gradient h-100">
                <div class="card-header">
                  <h4 class="card-title mb-0"><i class="ti ti-heartbeat me-2"></i>Patient Management</h4>
                </div>
                <div class="card-body">
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="list_patient" value="1"
                      id="list_patient">
                    <label class="form-check-label" for="list_patient">List Patients</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="patient_add" value="1"
                      id="patient_add">
                    <label class="form-check-label" for="patient_add">Add Patient</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="patient_edit" value="1"
                      id="patient_edit">
                    <label class="form-check-label" for="patient_edit">Edit Patient</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="patient_view" value="1"
                      id="patient_view">
                    <label class="form-check-label" for="patient_view">View Patient</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="patient_delete" value="1"
                      id="patient_delete">
                    <label class="form-check-label" for="patient_delete">Delete Patient</label>
                  </div>
                </div>
              </div>
            </div>

            <!-- Case Management -->
            <div class="col-md-6 mb-3">
              <div class="card card-gradient h-100">
                <div class="card-header">
                  <h4 class="card-title mb-0"><i class="ti ti-clipboard-list me-2"></i>Case Management</h4>
                </div>
                <div class="card-body">
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="case_add" value="1"
                      id="case_add">
                    <label class="form-check-label" for="case_add">Add Case</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="list_case" value="1"
                      id="list_case">
                    <label class="form-check-label" for="list_case">List Cases</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="case_edit" value="1"
                      id="case_edit">
                    <label class="form-check-label" for="case_edit">Edit Case</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="case_view" value="1"
                      id="case_view">
                    <label class="form-check-label" for="case_view">View Case</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="case_delete" value="1"
                      id="case_delete">
                    <label class="form-check-label" for="case_delete">Delete Case</label>
                  </div>
                </div>
              </div>
            </div>

            <!-- User Management -->
            <div class="col-md-6 mb-3">
              <div class="card card-gradient h-100">
                <div class="card-header">
                  <h4 class="card-title mb-0"><i class="ti ti-user-cog me-2"></i>User Management</h4>
                </div>
                <div class="card-body">
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="user_add" value="1"
                      id="user_add">
                    <label class="form-check-label" for="user_add">Add User</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="user_edit" value="1"
                      id="user_edit">
                    <label class="form-check-label" for="user_edit">Edit User</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="user_view" value="1"
                      id="user_view">
                    <label class="form-check-label" for="user_view">View User</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="user_delete" value="1"
                      id="user_delete">
                    <label class="form-check-label" for="user_delete">Delete User</label>
                  </div>
                  <hr>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="usertype_add" value="1"
                      id="usertype_add">
                    <label class="form-check-label" for="usertype_add">Add User Type</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="usertype_view" value="1"
                      id="usertype_view">
                    <label class="form-check-label" for="usertype_view">View User Type</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="usertype_edit" value="1"
                      id="usertype_edit">
                    <label class="form-check-label" for="usertype_edit">Edit User Type</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="usertype_delete" value="1"
                      id="usertype_delete">
                    <label class="form-check-label" for="usertype_delete">Delete User Type</label>
                  </div>
                </div>
              </div>
            </div>

            <!-- Confinement Management -->
            <div class="col-md-6 mb-3">
              <div class="card card-gradient h-100">
                <div class="card-header">
                  <h4 class="card-title mb-0"><i class="ti ti-bed me-2"></i>Confinement Management</h4>
                </div>
                <div class="card-body">
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="confinement_plot_item"
                      value="1" id="confinement_plot_item">
                    <label class="form-check-label" for="confinement_plot_item">Plot Item</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="confinement_give_meds"
                      value="1" id="confinement_give_meds">
                    <label class="form-check-label" for="confinement_give_meds">Give Medication</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input permission-checkbox" type="checkbox"
                      name="confinement_client_updates" value="1" id="confinement_client_updates">
                    <label class="form-check-label" for="confinement_client_updates">Client Updates</label>
                  </div>
                </div>
              </div>
            </div>

            <!-- Billing Management -->
            <div class="col-md-6 mb-3">
              <div class="card card-gradient h-100">
                <div class="card-header">
                  <h4 class="card-title mb-0"><i class="ti ti-receipt me-2"></i>Billing Management</h4>
                </div>
                <div class="card-body">
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="billing_view" value="1"
                      id="billing_view">
                    <label class="form-check-label" for="billing_view">View Billing</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="list_billing" value="1"
                      id="list_billing">
                    <label class="form-check-label" for="list_billing">List Billing</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="billing_add" value="1"
                      id="billing_add">
                    <label class="form-check-label" for="billing_add">Add Billing</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="billing_discount_check"
                      value="1" id="billing_discount_check">
                    <label class="form-check-label" for="billing_discount_check">Discount Approval</label>
                  </div>
                </div>
              </div>
            </div>

            <!-- Inventory Management -->
            <div class="col-md-6 mb-3">
              <div class="card card-gradient h-100">
                <div class="card-header">
                  <h4 class="card-title mb-0"><i class="ti ti-package me-2"></i>Inventory Management</h4>
                </div>
                <div class="card-body">
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="list_item" value="1"
                      id="list_item">
                    <label class="form-check-label" for="list_item">List Items</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="item_add" value="1"
                      id="item_add">
                    <label class="form-check-label" for="item_add">Add Item</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="item_edit" value="1"
                      id="item_edit">
                    <label class="form-check-label" for="item_edit">Edit Item</label>
                  </div>
                  <hr>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="list_po" value="1"
                      id="list_po">
                    <label class="form-check-label" for="list_po">List Purchase Orders</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="po_add" value="1"
                      id="po_add">
                    <label class="form-check-label" for="po_add">Add Purchase Order</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="po_view" value="1"
                      id="po_view">
                    <label class="form-check-label" for="po_view">View Purchase Order</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="po_edit" value="1"
                      id="po_edit">
                    <label class="form-check-label" for="po_edit">Edit Purchase Order</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="po_delete" value="1"
                      id="po_delete">
                    <label class="form-check-label" for="po_delete">Delete Purchase Order</label>
                  </div>
                </div>
              </div>
            </div>

            <!-- Voucher Management -->
            <div class="col-md-6 mb-3">
              <div class="card card-gradient h-100">
                <div class="card-header">
                  <h4 class="card-title mb-0"><i class="ti ti-ticket me-2"></i>Voucher Management</h4>
                </div>
                <div class="card-body">
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="list_voucher" value="1"
                      id="list_voucher">
                    <label class="form-check-label" for="list_voucher">List Vouchers</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="voucher_add" value="1"
                      id="voucher_add">
                    <label class="form-check-label" for="voucher_add">Add Voucher</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="voucher_view" value="1"
                      id="voucher_view">
                    <label class="form-check-label" for="voucher_view">View Voucher</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="voucher_edit" value="1"
                      id="voucher_edit">
                    <label class="form-check-label" for="voucher_edit">Edit Voucher</label>
                  </div>
                </div>
              </div>
            </div>

            <!-- Laboratory Management -->
            <div class="col-md-6 mb-3">
              <div class="card card-gradient h-100">
                <div class="card-header">
                  <h4 class="card-title mb-0"><i class="ti ti-microscope me-2"></i>Laboratory Management</h4>
                </div>
                <div class="card-body">
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="list_lab" value="1"
                      id="list_lab">
                    <label class="form-check-label" for="list_lab">List Laboratory Records</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="lab_add" value="1"
                      id="lab_add">
                    <label class="form-check-label" for="lab_add">Add Laboratory Record</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="lab_edit" value="1"
                      id="lab_edit">
                    <label class="form-check-label" for="lab_edit">Edit Laboratory Record</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="lab_delete" value="1"
                      id="lab_delete">
                    <label class="form-check-label" for="lab_delete">Delete Laboratory Record</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="serum_chem_view" value="1"
                      id="serum_chem_view">
                    <label class="form-check-label" for="serum_chem_view">View Serum Chemistry</label>
                  </div>
                </div>
              </div>
            </div>

            <!-- Clinic Services -->
            <div class="col-md-6 mb-3">
              <div class="card card-gradient h-100">
                <div class="card-header">
                  <h4 class="card-title mb-0"><i class="ti ti-stethoscope me-2"></i>Clinic Services</h4>
                </div>
                <div class="card-body">
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="list_clinic_service"
                      value="1" id="list_clinic_service">
                    <label class="form-check-label" for="list_clinic_service">List Clinic Services</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="add_clinic_service"
                      value="1" id="add_clinic_service">
                    <label class="form-check-label" for="add_clinic_service">Add Clinic Service</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="edit_clinic_service"
                      value="1" id="edit_clinic_service">
                    <label class="form-check-label" for="edit_clinic_service">Edit Clinic Service</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="delete_clinic_service"
                      value="1" id="delete_clinic_service">
                    <label class="form-check-label" for="delete_clinic_service">Delete Clinic Service</label>
                  </div>
                </div>
              </div>
            </div>

            <!-- Supplier Management -->
            <div class="col-md-6 mb-3">
              <div class="card card-gradient h-100">
                <div class="card-header">
                  <h4 class="card-title mb-0"><i class="ti ti-truck-delivery me-2"></i>Supplier Management</h4>
                </div>
                <div class="card-body">
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="list_supplier" value="1"
                      id="list_supplier">
                    <label class="form-check-label" for="list_supplier">List Suppliers</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="add_supplier" value="1"
                      id="add_supplier">
                    <label class="form-check-label" for="add_supplier">Add Supplier</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="edit_supplier" value="1"
                      id="edit_supplier">
                    <label class="form-check-label" for="edit_supplier">Edit Supplier</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="delete_supplier" value="1"
                      id="delete_supplier">
                    <label class="form-check-label" for="delete_supplier">Delete Supplier</label>
                  </div>
                </div>
              </div>
            </div>

            <!-- Efficacy Management -->
            <div class="col-md-6 mb-3">
              <div class="card card-gradient h-100">
                <div class="card-header">
                  <h4 class="card-title mb-0"><i class="ti ti-chart-line me-2"></i>Efficacy Management</h4>
                </div>
                <div class="card-body">
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="list_efficacy" value="1"
                      id="list_efficacy">
                    <label class="form-check-label" for="list_efficacy">List Efficacy Records</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="add_efficacy" value="1"
                      id="add_efficacy">
                    <label class="form-check-label" for="add_efficacy">Add Efficacy Record</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="edit_efficacy" value="1"
                      id="edit_efficacy">
                    <label class="form-check-label" for="edit_efficacy">Edit Efficacy Record</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="delete_efficacy" value="1"
                      id="delete_efficacy">
                    <label class="form-check-label" for="delete_efficacy">Delete Efficacy Record</label>
                  </div>
                </div>
              </div>
            </div>

            <!-- Vaccine Management -->
            <div class="col-md-6 mb-3">
              <div class="card card-gradient h-100">
                <div class="card-header">
                  <h4 class="card-title mb-0"><i class="ti ti-vaccine me-2"></i>Vaccine Management</h4>
                </div>
                <div class="card-body">
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="list_vaccine" value="1"
                      id="list_vaccine">
                    <label class="form-check-label" for="list_vaccine">List Vaccines</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="add_vaccine" value="1"
                      id="add_vaccine">
                    <label class="form-check-label" for="add_vaccine">Add Vaccine</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="edit_vaccine" value="1"
                      id="edit_vaccine">
                    <label class="form-check-label" for="edit_vaccine">Edit Vaccine</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="delete_vaccine" value="1"
                      id="delete_vaccine">
                    <label class="form-check-label" for="delete_vaccine">Delete Vaccine</label>
                  </div>
                </div>
              </div>
            </div>

            <!-- Diagnosis Management -->
            <div class="col-md-6 mb-3">
              <div class="card card-gradient h-100">
                <div class="card-header">
                  <h4 class="card-title mb-0"><i class="ti ti-report-medical me-2"></i>Diagnosis Management</h4>
                </div>
                <div class="card-body">
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="list_diagnosis" value="1"
                      id="list_diagnosis">
                    <label class="form-check-label" for="list_diagnosis">List Diagnoses</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="add_diagnosis" value="1"
                      id="add_diagnosis">
                    <label class="form-check-label" for="add_diagnosis">Add Diagnosis</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="edit_diagnosis" value="1"
                      id="edit_diagnosis">
                    <label class="form-check-label" for="edit_diagnosis">Edit Diagnosis</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="delete_diagnosis"
                      value="1" id="delete_diagnosis">
                    <label class="form-check-label" for="delete_diagnosis">Delete Diagnosis</label>
                  </div>
                </div>
              </div>
            </div>

            <!-- Species Management -->
            <div class="col-md-6 mb-3">
              <div class="card card-gradient h-100">
                <div class="card-header">
                  <h4 class="card-title mb-0"><i class="ti ti-paw me-2"></i>Species Management</h4>
                </div>
                <div class="card-body">
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="list_species" value="1"
                      id="list_species">
                    <label class="form-check-label" for="list_species">List Species</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="add_species" value="1"
                      id="add_species">
                    <label class="form-check-label" for="add_species">Add Species</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="edit_species" value="1"
                      id="edit_species">
                    <label class="form-check-label" for="edit_species">Edit Species</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="delete_species" value="1"
                      id="delete_species">
                    <label class="form-check-label" for="delete_species">Delete Species</label>
                  </div>
                </div>
              </div>
            </div>

            <!-- Breed Management -->
            <div class="col-md-6 mb-3">
              <div class="card card-gradient h-100">
                <div class="card-header">
                  <h4 class="card-title mb-0"><i class="ti ti-dog me-2"></i>Breed Management</h4>
                </div>
                <div class="card-body">
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="list_breed" value="1"
                      id="list_breed">
                    <label class="form-check-label" for="list_breed">List Breeds</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="add_breed" value="1"
                      id="add_breed">
                    <label class="form-check-label" for="add_breed">Add Breed</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="edit_breed" value="1"
                      id="edit_breed">
                    <label class="form-check-label" for="edit_breed">Edit Breed</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="delete_breed" value="1"
                      id="delete_breed">
                    <label class="form-check-label" for="delete_breed">Delete Breed</label>
                  </div>
                </div>
              </div>
            </div>

            <!-- Category Management -->
            <div class="col-md-6 mb-3">
              <div class="card card-gradient h-100">
                <div class="card-header">
                  <h4 class="card-title mb-0"><i class="ti ti-category me-2"></i>Category Management</h4>
                </div>
                <div class="card-body">
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="list_category" value="1"
                      id="list_category">
                    <label class="form-check-label" for="list_category">List Categories</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="add_category" value="1"
                      id="add_category">
                    <label class="form-check-label" for="add_category">Add Category</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="edit_category" value="1"
                      id="edit_category">
                    <label class="form-check-label" for="edit_category">Edit Category</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="delete_category" value="1"
                      id="delete_category">
                    <label class="form-check-label" for="delete_category">Delete Category</label>
                  </div>
                </div>
              </div>
            </div>

            <!-- Appointment Services -->
            <div class="col-md-6 mb-3">
              <div class="card card-gradient h-100">
                <div class="card-header">
                  <h4 class="card-title mb-0"><i class="ti ti-calendar-check me-2"></i>Appointment Services</h4>
                </div>
                <div class="card-body">
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="list_appointment_service"
                      value="1" id="list_appointment_service">
                    <label class="form-check-label" for="list_appointment_service">List Appointment Services</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="add_appointment_service"
                      value="1" id="add_appointment_service">
                    <label class="form-check-label" for="add_appointment_service">Add Appointment Service</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input permission-checkbox" type="checkbox"
                      name="delete_appointment_service" value="1" id="delete_appointment_service">
                    <label class="form-check-label" for="delete_appointment_service">Delete Appointment Service</label>
                  </div>
                </div>
              </div>
            </div>

            <!-- Headline Management -->
            <div class="col-md-6 mb-3">
              <div class="card card-gradient h-100">
                <div class="card-header">
                  <h4 class="card-title mb-0"><i class="ti ti-news me-2"></i>Headline Management</h4>
                </div>
                <div class="card-body">
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="list_headline" value="1"
                      id="list_headline">
                    <label class="form-check-label" for="list_headline">List Headlines</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="add_headline" value="1"
                      id="add_headline">
                    <label class="form-check-label" for="add_headline">Add Headline</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="edit_headline" value="1"
                      id="edit_headline">
                    <label class="form-check-label" for="edit_headline">Edit Headline</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="delete_headline" value="1"
                      id="delete_headline">
                    <label class="form-check-label" for="delete_headline">Delete Headline</label>
                  </div>
                </div>
              </div>
            </div>

            <!-- Channel Management -->
            <div class="col-md-6 mb-3">
              <div class="card card-gradient h-100">
                <div class="card-header">
                  <h4 class="card-title mb-0"><i class="ti ti-broadcast me-2"></i>Channel Management</h4>
                </div>
                <div class="card-body">
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="list_channel" value="1"
                      id="list_channel">
                    <label class="form-check-label" for="list_channel">List Channels</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="add_channel" value="1"
                      id="add_channel">
                    <label class="form-check-label" for="add_channel">Add Channel</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="edit_channel" value="1"
                      id="edit_channel">
                    <label class="form-check-label" for="edit_channel">Edit Channel</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="delete_channel" value="1"
                      id="delete_channel">
                    <label class="form-check-label" for="delete_channel">Delete Channel</label>
                  </div>
                </div>
              </div>
            </div>

            <!-- Reports & Analytics -->
            <div class="col-md-6 mb-3">
              <div class="card card-gradient h-100">
                <div class="card-header">
                  <h4 class="card-title mb-0"><i class="ti ti-chart-bar me-2"></i>Reports & Analytics</h4>
                </div>
                <div class="card-body">
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="user_stat_report"
                      value="1" id="user_stat_report">
                    <label class="form-check-label" for="user_stat_report">User Statistics Report</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="patient_deceased_report"
                      value="1" id="patient_deceased_report">
                    <label class="form-check-label" for="patient_deceased_report">Patient Deceased Report</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="confinement_record_report"
                      value="1" id="confinement_record_report">
                    <label class="form-check-label" for="confinement_record_report">Confinement Record Report</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="case_log_report" value="1"
                      id="case_log_report">
                    <label class="form-check-label" for="case_log_report">Case Log Report</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="case_diagnosis_report"
                      value="1" id="case_diagnosis_report">
                    <label class="form-check-label" for="case_diagnosis_report">Case Diagnosis Report</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="case_followup_report"
                      value="1" id="case_followup_report">
                    <label class="form-check-label" for="case_followup_report">Case Follow-up Report</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="vaccination_exp_report"
                      value="1" id="vaccination_exp_report">
                    <label class="form-check-label" for="vaccination_exp_report">Vaccination Expiration Report</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="registration_report"
                      value="1" id="registration_report">
                    <label class="form-check-label" for="registration_report">Registration Report</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="reorder_level_report"
                      value="1" id="reorder_level_report">
                    <label class="form-check-label" for="reorder_level_report">Reorder Level Report</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="sales_breakdown_report"
                      value="1" id="sales_breakdown_report">
                    <label class="form-check-label" for="sales_breakdown_report">Sales Breakdown Report</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="sales_turnover_report"
                      value="1" id="sales_turnover_report">
                    <label class="form-check-label" for="sales_turnover_report">Sales Turnover Report</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="clinic_service_report"
                      value="1" id="clinic_service_report">
                    <label class="form-check-label" for="clinic_service_report">Clinic Service Report</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="clinic_inventory_report"
                      value="1" id="clinic_inventory_report">
                    <label class="form-check-label" for="clinic_inventory_report">Clinic Inventory Report</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="lab_report" value="1"
                      id="lab_report">
                    <label class="form-check-label" for="lab_report">Laboratory Report</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="lab_inventory_report"
                      value="1" id="lab_inventory_report">
                    <label class="form-check-label" for="lab_inventory_report">Laboratory Inventory Report</label>
                  </div>
                </div>
              </div>
            </div>

            <!-- Other Permissions -->
            <div class="col-md-6 mb-3">
              <div class="card card-gradient h-100">
                <div class="card-header">
                  <h4 class="card-title mb-0"><i class="ti ti-settings me-2"></i>Other Permissions</h4>
                </div>
                <div class="card-body">
                  <div class="form-check mb-2">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="delete_history_view"
                      value="1" id="delete_history_view">
                    <label class="form-check-label" for="delete_history_view">View Deleted History</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input permission-checkbox" type="checkbox" name="sms_sending_view"
                      value="1" id="sms_sending_view">
                    <label class="form-check-label" for="sms_sending_view">SMS Sending</label>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Cancel
          </button>
          <button type="submit" class="btn btn-primary">
            Save User Type
          </button>
        </div>
      </form>

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

    $('#addUserTypeForm').on('submit', function (e) {
      e.preventDefault();

      const btn = $('#addUserTypeModal').find('button[type="submit"]');
      const originalText = btn.html();

      btn.prop('disabled', true);
      btn.html('<i class="ti ti-loader me-2"></i> Saving...');

      $.ajax({
        url: './../controllers/add_user_type_process.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',

        success: function (response) {

          if (response.success) {

            toastr.success(response.message);

            // Reset form
            $('#addUserTypeForm')[0].reset();

            // Close modal
            $('#addUserTypeModal').modal('hide');

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