<?php

header('Content-Type: application/json');

include './../connections/connections.php';

// Start session (PHP 5 compatible)
if (session_id() == '') {
  session_start();
}

// Validate request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

  echo json_encode(array(
    'success' => false,
    'message' => 'Invalid request method.'
  ));

  exit;
}

// Get User Type ID
$user_type_id = isset($_POST['user_type_id'])
  ? intval($_POST['user_type_id'])
  : 0;

if ($user_type_id <= 0) {

  echo json_encode(array(
    'success' => false,
    'message' => 'Invalid user type ID.'
  ));

  exit;
}

// Get User Type Name
$user_type_name = isset($_POST['user_type_name'])
  ? trim($_POST['user_type_name'])
  : '';

if ($user_type_name === '') {

  echo json_encode(array(
    'success' => false,
    'message' => 'Please enter a user type name.'
  ));

  exit;
}

$user_type_name = $conn->real_escape_string($user_type_name);

// Get Case Doctor Status
$case_doctor = isset($_POST['case_doctor'])
  ? strtolower(trim($_POST['case_doctor']))
  : '';

if (!in_array($case_doctor, array('enabled', 'disabled'), true)) {

  echo json_encode(array(
    'success' => false,
    'message' => 'Invalid Case Doctor status.'
  ));

  exit;
}

$case_doctor = $conn->real_escape_string($case_doctor);

// Get Billing Discount Percentage
$billing_discount_percentage = isset($_POST['billing_discount_percentage'])
  ? trim($_POST['billing_discount_percentage'])
  : '';

if (!preg_match('/^(100|[1-9][0-9]?)$/', $billing_discount_percentage)) {

  echo json_encode(array(
    'success' => false,
    'message' => 'Discount must be between 1 and 100.'
  ));

  exit;
}

$billing_discount_percentage = intval($billing_discount_percentage);


// ======================================================
// PERMISSION COLUMNS
// All permission columns from modal_add_user_type
// ======================================================

$permission_fields = array(

  // Client Management
  'list_client',
  'client_add',
  'client_edit',
  'client_view',
  'client_delete',

  // Patient Management
  'list_patient',
  'patient_add',
  'patient_edit',
  'patient_view',
  'patient_delete',

  // Case Management
  'case_add',
  'list_case',
  'case_edit',
  'case_view',
  'case_delete',

  // User Management
  'user_add',
  'user_edit',
  'user_view',
  'user_delete',
  'usertype_add',
  'usertype_view',
  'usertype_edit',
  'usertype_delete',

  // Confinement Management
  'confinement_plot_item',
  'confinement_give_meds',
  'confinement_client_updates',

  // Billing Management
  'billing_view',
  'list_billing',
  'billing_add',
  'billing_discount_check',

  // Inventory Management
  'list_item',
  'item_add',
  'item_edit',
  'list_po',
  'po_add',
  'po_view',
  'po_edit',
  'po_delete',

  // Voucher Management
  'list_voucher',
  'voucher_add',
  'voucher_view',
  'voucher_edit',

  // Laboratory Management
  'list_lab',
  'lab_add',
  'lab_edit',
  'lab_delete',
  'serum_chem_view',

  // Clinic Services
  'list_clinic_service',
  'add_clinic_service',
  'edit_clinic_service',
  'delete_clinic_service',

  // Supplier Management
  'list_supplier',
  'add_supplier',
  'edit_supplier',
  'delete_supplier',

  // Efficacy Management
  'list_efficacy',
  'add_efficacy',
  'edit_efficacy',
  'delete_efficacy',

  // Vaccine Management
  'list_vaccine',
  'add_vaccine',
  'edit_vaccine',
  'delete_vaccine',

  // Diagnosis Management
  'list_diagnosis',
  'add_diagnosis',
  'edit_diagnosis',
  'delete_diagnosis',

  // Species Management
  'list_species',
  'add_species',
  'edit_species',
  'delete_species',

  // Breed Management
  'list_breed',
  'add_breed',
  'edit_breed',
  'delete_breed',

  // Category Management
  'list_category',
  'add_category',
  'edit_category',
  'delete_category',

  // Appointment Services
  'list_appointment_service',
  'add_appointment_service',
  'delete_appointment_service',

  // Headline Management
  'list_headline',
  'add_headline',
  'edit_headline',
  'delete_headline',

  // Channel Management
  'list_channel',
  'add_channel',
  'edit_channel',
  'delete_channel',

  // Reports and Analytics
  'user_stat_report',
  'patient_deceased_report',
  'confinement_record_report',
  'case_log_report',
  'case_diagnosis_report',
  'case_followup_report',
  'vaccination_exp_report',
  'registration_report',
  'reorder_level_report',
  'sales_breakdown_report',
  'sales_turnover_report',
  'clinic_service_report',
  'clinic_inventory_report',
  'lab_report',
  'lab_inventory_report',

  // Other Permissions
  'delete_history_view',
  'sms_sending_view'

);


// ======================================================
// CHECK IF USER TYPE EXISTS
// ======================================================

$check_id = $conn->query("
    SELECT user_type_id
    FROM z_user_restriction
    WHERE user_type_id = $user_type_id
");

if (!$check_id) {

  echo json_encode(array(
    'success' => false,
    'message' => 'Database error: ' . $conn->error
  ));

  exit;
}

if ($check_id->num_rows == 0) {

  echo json_encode(array(
    'success' => false,
    'message' => 'User role not found.'
  ));

  exit;
}


// ======================================================
// CHECK DUPLICATE USER TYPE NAME
// ======================================================

$check_name = $conn->query("
    SELECT user_type_id
    FROM z_user_restriction
    WHERE user_type_name = '$user_type_name'
    AND user_type_id != $user_type_id
");

if (!$check_name) {

  echo json_encode(array(
    'success' => false,
    'message' => 'Database error: ' . $conn->error
  ));

  exit;
}

if ($check_name->num_rows > 0) {

  echo json_encode(array(
    'success' => false,
    'message' => 'User type name already exists.'
  ));

  exit;
}


// ======================================================
// BUILD PERMISSION UPDATE
// Checked checkbox = 1
// Unchecked checkbox = 0
// ======================================================

$permission_updates = array();

foreach ($permission_fields as $field) {

  if (isset($_POST[$field]) && $_POST[$field] == '1') {

    $permission_value = 1;

  } else {

    $permission_value = 0;

  }

  // Column names come only from the predefined whitelist above.
  $permission_updates[] = "`" . $field . "` = " . $permission_value;

}


// ======================================================
// UPDATE USER TYPE
// ======================================================

$sql = "
    UPDATE z_user_restriction
    SET
        user_type_name = '$user_type_name',
        case_doctor = '$case_doctor',
        billing_discount_percentage = '$billing_discount_percentage',
        " . implode(", ", $permission_updates) . "
    WHERE user_type_id = $user_type_id
";


// ======================================================
// EXECUTE UPDATE
// ======================================================

if ($conn->query($sql)) {

  echo json_encode(array(
    'success' => true,
    'message' => 'User role successfully updated.'
  ));

} else {

  echo json_encode(array(
    'success' => false,
    'message' => 'Failed to update user role: ' . $conn->error
  ));

}


// Close database connection
$conn->close();

?>