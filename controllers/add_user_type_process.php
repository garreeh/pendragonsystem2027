<?php
header('Content-Type: application/json');

include './../connections/connections.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode([
    'success' => false,
    'message' => 'Invalid request method.'
  ]);
  exit;
}

// Get user type name
$user_type_name = isset($_POST['user_type_name'])
  ? trim($conn->real_escape_string($_POST['user_type_name']))
  : '';

if ($user_type_name === '') {
  echo json_encode([
    'success' => false,
    'message' => 'Please enter a user type name.'
  ]);
  exit;
}

// Check if user type already exists
$check = $conn->query("
    SELECT user_type_name
    FROM z_user_restriction
    WHERE user_type_name = '$user_type_name'
");

if (!$check) {
  echo json_encode([
    'success' => false,
    'message' => 'Database error: ' . $conn->error
  ]);
  exit;
}

if ($check->num_rows > 0) {
  echo json_encode([
    'success' => false,
    'message' => 'User type already exists.'
  ]);
  exit;
}

// All permission fields from the Add User Type form
$permission_fields = [
  // Client
  'list_client',
  'client_add',
  'client_edit',
  'client_view',
  'client_delete',

  // Patient
  'list_patient',
  'patient_add',
  'patient_edit',
  'patient_view',
  'patient_delete',

  // Case
  'case_doctor',
  'case_add',
  'list_case',
  'case_edit',
  'case_view',
  'case_delete',

  // User
  'user_add',
  'user_edit',
  'user_view',
  'user_delete',
  'usertype_add',
  'usertype_view',
  'usertype_edit',
  'usertype_delete',

  // Confinement
  'confinement_plot_item',
  'confinement_give_meds',
  'confinement_client_updates',

  // Billing
  'billing_view',
  'list_billing',
  'billing_add',
  'billing_discount_percentage',
  'billing_discount_check',

  // Inventory
  'list_item',
  'item_add',
  'item_edit',

  // Purchase Order
  'list_po',
  'po_add',
  'po_view',
  'po_edit',
  'po_delete',

  // Voucher
  'list_voucher',
  'voucher_add',
  'voucher_view',
  'voucher_edit',

  // Laboratory
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

  // Supplier
  'list_supplier',
  'add_supplier',
  'edit_supplier',
  'delete_supplier',

  // Efficacy
  'list_efficacy',
  'add_efficacy',
  'edit_efficacy',
  'delete_efficacy',

  // Vaccine
  'list_vaccine',
  'add_vaccine',
  'edit_vaccine',
  'delete_vaccine',

  // Diagnosis
  'list_diagnosis',
  'add_diagnosis',
  'edit_diagnosis',
  'delete_diagnosis',

  // Species
  'list_species',
  'add_species',
  'edit_species',
  'delete_species',

  // Breed
  'list_breed',
  'add_breed',
  'edit_breed',
  'delete_breed',

  // Category
  'list_category',
  'add_category',
  'edit_category',
  'delete_category',

  // Appointment Services
  'list_appointment_service',
  'add_appointment_service',
  'delete_appointment_service',

  // Headline
  'list_headline',
  'add_headline',
  'edit_headline',
  'delete_headline',

  // Channel
  'list_channel',
  'add_channel',
  'edit_channel',
  'delete_channel',

  // Reports
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

  // Other
  'delete_history_view',
  'sms_sending_view'
];

// Build permission values
$columns = [];
$values = [];

foreach ($permission_fields as $field) {
  $columns[] = "`$field`";

  // Checked = 1, unchecked = 0
  $value = isset($_POST[$field]) &&
    in_array($_POST[$field], ['1', 'on', 'true'], true)
    ? 1
    : 0;

  $values[] = $value;
}

// Add user type name to the beginning
array_unshift($columns, '`user_type_name`');
array_unshift($values, "'$user_type_name'");

// Build INSERT query
$sql = "
    INSERT INTO z_user_restriction (
        " . implode(', ', $columns) . "
    ) VALUES (
        " . implode(', ', $values) . "
    )
";

// Execute query
if ($conn->query($sql)) {
  echo json_encode([
    'success' => true,
    'message' => 'User type successfully added.'
  ]);
} else {
  echo json_encode([
    'success' => false,
    'message' => 'Failed to add user type: ' . $conn->error
  ]);
}

$conn->close();
?>