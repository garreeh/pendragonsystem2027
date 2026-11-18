<?php
session_start();
include './../connections/connections.php';

header('Content-Type: application/json');

date_default_timezone_set("Asia/Manila");

// Check request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(array(
    'success' => false,
    'message' => 'Invalid request method.'
  ));
  exit;
}

// Check user session
if (!isset($_SESSION['user_id'])) {
  echo json_encode(array(
    'success' => false,
    'message' => 'Your session has expired. Please log in again.'
  ));
  exit;
}

// Get POST values
$first_name = isset($_POST['client_firstname'])
  ? trim($_POST['client_firstname'])
  : '';

$last_name = isset($_POST['client_lastname'])
  ? trim($_POST['client_lastname'])
  : '';

$client_address = isset($_POST['client_address'])
  ? trim($_POST['client_address'])
  : '';

$client_remarks = isset($_POST['client_remarks'])
  ? trim($_POST['client_remarks'])
  : '';

$street_no = isset($_POST['street_no'])
  ? trim($_POST['street_no'])
  : '';

$street = isset($_POST['street'])
  ? trim($_POST['street'])
  : '';

$barangay = isset($_POST['barangay'])
  ? trim($_POST['barangay'])
  : '';

$district = isset($_POST['district'])
  ? trim($_POST['district'])
  : '';

$city = isset($_POST['city'])
  ? trim($_POST['city'])
  : '';

$province = isset($_POST['province'])
  ? trim($_POST['province'])
  : '';

$postal_code = isset($_POST['postal_code'])
  ? trim($_POST['postal_code'])
  : '';

// Get contact arrays
$contact_types = isset($_POST['contact_type'])
  ? $_POST['contact_type']
  : array();

$contact_details = isset($_POST['contact_detail'])
  ? $_POST['contact_detail']
  : array();

// Validate required fields
if ($first_name === '' || $last_name === '') {
  echo json_encode(array(
    'success' => false,
    'message' => 'Please enter the client first name and last name.'
  ));
  exit;
}

// Validate contact arrays
if (!is_array($contact_types) || !is_array($contact_details)) {
  echo json_encode(array(
    'success' => false,
    'message' => 'Invalid contact information submitted.'
  ));
  exit;
}

if (count($contact_types) != count($contact_details)) {
  echo json_encode(array(
    'success' => false,
    'message' => 'Contact information is incomplete.'
  ));
  exit;
}

// Allowed contact types
$allowedTypes = array(
  'mobile',
  'telephone',
  'email',
  'facebook',
  'website'
);

// Validate and prepare contacts
$contacts = array();

for ($i = 0; $i < count($contact_details); $i++) {

  $contact_type = isset($contact_types[$i])
    ? trim($contact_types[$i])
    : '';

  $contact_detail = isset($contact_details[$i])
    ? trim($contact_details[$i])
    : '';

  // Ignore empty contact rows
  if ($contact_detail === '') {
    continue;
  }

  // Validate contact type
  if (!in_array($contact_type, $allowedTypes)) {
    echo json_encode(array(
      'success' => false,
      'message' => 'Invalid contact type selected.'
    ));
    exit;
  }

  // Validate contact details
  if ($contact_type == 'mobile' || $contact_type == 'telephone') {

    $contact_detail = preg_replace('/[^0-9]/', '', $contact_detail);

    if (strlen($contact_detail) < 7 || strlen($contact_detail) > 15) {
      echo json_encode(array(
        'success' => false,
        'message' => 'Mobile or telephone number must contain 7 to 15 digits.'
      ));
      exit;
    }

  } elseif ($contact_type == 'email') {

    if (!filter_var($contact_detail, FILTER_VALIDATE_EMAIL)) {
      echo json_encode(array(
        'success' => false,
        'message' => 'Please enter a valid contact email address.'
      ));
      exit;
    }

  } elseif ($contact_type == 'facebook') {

    $facebookUrl = '/^(https?:\/\/)?(www\.)?(facebook\.com|fb\.com)\/[A-Za-z0-9._-]+\/?$/i';
    $facebookUsername = '/^@?[A-Za-z0-9._]{3,}$/';

    if (
      !preg_match($facebookUrl, $contact_detail) &&
      !preg_match($facebookUsername, $contact_detail)
    ) {
      echo json_encode(array(
        'success' => false,
        'message' => 'Enter a valid Facebook profile URL or username.'
      ));
      exit;
    }

  } elseif ($contact_type == 'website') {

    if (
      !filter_var($contact_detail, FILTER_VALIDATE_URL) ||
      !preg_match('/^https?:\/\//i', $contact_detail)
    ) {
      echo json_encode(array(
        'success' => false,
        'message' => 'Enter a valid website URL starting with http:// or https://.'
      ));
      exit;
    }
  }

  $contacts[] = array(
    'type' => $contact_type,
    'detail' => $contact_detail
  );
}

// Escape client values
$first_name = $conn->real_escape_string(strip_tags($first_name));
$last_name = $conn->real_escape_string(strip_tags($last_name));

$client_address = $conn->real_escape_string(strip_tags($client_address));
$client_remarks = $conn->real_escape_string(strip_tags($client_remarks));

$street_no = $conn->real_escape_string(strip_tags($street_no));
$street = $conn->real_escape_string(strip_tags($street));
$barangay = $conn->real_escape_string(strip_tags($barangay));
$district = $conn->real_escape_string(strip_tags($district));
$city = $conn->real_escape_string(strip_tags($city));
$province = $conn->real_escape_string(strip_tags($province));
$postal_code = $conn->real_escape_string(strip_tags($postal_code));

// Current date and time
$currentDate = date('Y-m-d H:i:s');

// Start transaction
if (!mysqli_query($conn, "START TRANSACTION")) {
  echo json_encode(array(
    'success' => false,
    'message' => 'Unable to start database transaction.'
  ));
  exit;
}

// Insert client record
$insertClient = "
    INSERT INTO client (
        client_firstname,
        client_lastname,
        client_address,
        client_remarks,
        client_streetno,
        client_street,
        client_barangay,
        client_district,
        client_city,
        client_province,
        client_zip,
        client_locked,
        client_datecreated
    ) VALUES (
        '$first_name',
        '$last_name',
        '$client_address',
        '$client_remarks',
        '$street_no',
        '$street',
        '$barangay',
        '$district',
        '$city',
        '$province',
        '$postal_code',
        'no',
        '$currentDate'
    )
";

$insertClientResult = mysqli_query($conn, $insertClient);

if (!$insertClientResult) {

  mysqli_query($conn, "ROLLBACK");

  echo json_encode(array(
    'success' => false,
    'message' => 'Unable to create client record. Please try again.'
  ));

  exit;
}

// Get newly created client ID
$client_id = mysqli_insert_id($conn);

if ($client_id <= 0) {

  mysqli_query($conn, "ROLLBACK");

  echo json_encode(array(
    'success' => false,
    'message' => 'Unable to retrieve the new client ID.'
  ));

  exit;
}

// Insert additional contact details
foreach ($contacts as $contact) {

  $contact_type = $conn->real_escape_string($contact['type']);
  $contact_detail = $conn->real_escape_string($contact['detail']);

  $insertContact = "
        INSERT INTO client_contact (
            client_id,
            client_contact_type,
            client_contact_detail,
            client_contact_datecreated,
            client_contact_dateupdated
        ) VALUES (
            '$client_id',
            '$contact_type',
            '$contact_detail',
            '$currentDate',
            '$currentDate'
        )
    ";

  $contactResult = mysqli_query($conn, $insertContact);

  if (!$contactResult) {

    mysqli_query($conn, "ROLLBACK");

    echo json_encode(array(
      'success' => false,
      'message' => 'Client creation failed while saving contact details.'
    ));

    exit;
  }
}

// Commit transaction
if (!mysqli_query($conn, "COMMIT")) {

  mysqli_query($conn, "ROLLBACK");

  echo json_encode(array(
    'success' => false,
    'message' => 'Unable to complete client creation.'
  ));

  exit;
}

// Success response
echo json_encode(array(
  'success' => true,
  'message' => 'Client has been successfully added.'
));

$conn->close();
exit;
?>