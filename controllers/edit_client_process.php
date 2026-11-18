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
$client_id = isset($_POST['client_id']) ? (int) $_POST['client_id'] : 0;

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

// Get contact arrays
$contact_ids = isset($_POST['contact_id'])
  ? $_POST['contact_id']
  : array();

$contact_types = isset($_POST['contact_type'])
  ? $_POST['contact_type']
  : array();

$contact_details = isset($_POST['contact_detail'])
  ? $_POST['contact_detail']
  : array();

// Validate required fields
if (
  $client_id <= 0 ||
  $first_name === '' ||
  $last_name === ''
) {
  echo json_encode(array(
    'success' => false,
    'message' => 'Please complete all required fields.'
  ));
  exit;
}

// Sanitize and escape client information
$first_name = $conn->real_escape_string(strip_tags($first_name));
$last_name = $conn->real_escape_string(strip_tags($last_name));

$client_address = $conn->real_escape_string(
  strip_tags($client_address)
);

$client_remarks = $conn->real_escape_string(
  strip_tags($client_remarks)
);

// Check if client exists
$checkClient = "
    SELECT client_id
    FROM client
    WHERE client_id = '$client_id'
";

$checkClientResult = mysqli_query($conn, $checkClient);

if (!$checkClientResult || mysqli_num_rows($checkClientResult) == 0) {
  echo json_encode(array(
    'success' => false,
    'message' => 'Client record not found.'
  ));
  exit;
}

// Allowed contact types
$allowedTypes = array(
  'mobile',
  'telephone',
  'facebook',
  'website',
  'email'
);

// Validate contact arrays
if (
  !is_array($contact_ids) ||
  !is_array($contact_types) ||
  !is_array($contact_details)
) {
  echo json_encode(array(
    'success' => false,
    'message' => 'Invalid contact information submitted.'
  ));
  exit;
}

if (
  count($contact_ids) != count($contact_types) ||
  count($contact_types) != count($contact_details)
) {
  echo json_encode(array(
    'success' => false,
    'message' => 'Contact information is incomplete.'
  ));
  exit;
}

// Prepare contact records
$contacts = array();
$submittedIds = array();

for ($i = 0; $i < count($contact_details); $i++) {

  $contact_id = isset($contact_ids[$i])
    ? (int) $contact_ids[$i]
    : 0;

  $contact_type = isset($contact_types[$i])
    ? trim($contact_types[$i])
    : '';

  $contact_detail = isset($contact_details[$i])
    ? trim($contact_details[$i])
    : '';

  // Ignore completely blank rows
  if ($contact_type === '' && $contact_detail === '') {
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

  // Require both type and detail
  if ($contact_type === '' || $contact_detail === '') {
    echo json_encode(array(
      'success' => false,
      'message' => 'Please complete all contact details or remove the blank row.'
    ));
    exit;
  }

  // Validate contact detail based on type
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

  } elseif ($contact_type == 'website') {

    if (!filter_var($contact_detail, FILTER_VALIDATE_URL)) {
      echo json_encode(array(
        'success' => false,
        'message' => 'Please enter a valid website URL.'
      ));
      exit;
    }

  } elseif ($contact_type == 'facebook') {

    if (strlen($contact_detail) > 255) {
      echo json_encode(array(
        'success' => false,
        'message' => 'Facebook contact detail is too long.'
      ));
      exit;
    }
  }

  // Prevent duplicate contact IDs
  if ($contact_id > 0) {

    if (in_array($contact_id, $submittedIds)) {
      echo json_encode(array(
        'success' => false,
        'message' => 'Duplicate contact record submitted.'
      ));
      exit;
    }

    $submittedIds[] = $contact_id;
  }

  $contacts[] = array(
    'id' => $contact_id,
    'type' => $conn->real_escape_string($contact_type),
    'detail' => $conn->real_escape_string($contact_detail)
  );
}

// Start transaction
mysqli_query($conn, "START TRANSACTION");

// Update client information
$updateClient = "
    UPDATE client SET
        client_firstname = '$first_name',
        client_lastname = '$last_name',
        client_address = '$client_address',
        client_remarks = '$client_remarks'
    WHERE client_id = '$client_id'
";

$updateClientResult = mysqli_query($conn, $updateClient);

if (!$updateClientResult) {

  mysqli_query($conn, "ROLLBACK");

  echo json_encode(array(
    'success' => false,
    'message' => 'Unable to update client information.'
  ));

  exit;
}

// Get existing contact records belonging to this client
$existingContacts = array();

$getContacts = "
    SELECT client_contact_id
    FROM client_contact
    WHERE client_id = '$client_id'
";

$getContactsResult = mysqli_query($conn, $getContacts);

if (!$getContactsResult) {

  mysqli_query($conn, "ROLLBACK");

  echo json_encode(array(
    'success' => false,
    'message' => 'Unable to retrieve client contact records.'
  ));

  exit;
}

while ($contactRow = mysqli_fetch_assoc($getContactsResult)) {
  $existingContacts[] = (int) $contactRow['client_contact_id'];
}

// Validate that submitted existing contact IDs belong to this client
foreach ($submittedIds as $submittedId) {

  if (!in_array($submittedId, $existingContacts)) {

    mysqli_query($conn, "ROLLBACK");

    echo json_encode(array(
      'success' => false,
      'message' => 'Invalid contact record detected.'
    ));

    exit;
  }
}

// Current date and time
$currentDate = date('Y-m-d H:i:s');

// Save contact records
foreach ($contacts as $contact) {

  $contact_id = (int) $contact['id'];
  $contact_type = $contact['type'];
  $contact_detail = $contact['detail'];

  // Update existing contact
  if ($contact_id > 0) {

    $updateContact = "
            UPDATE client_contact SET
                client_contact_type = '$contact_type',
                client_contact_detail = '$contact_detail',
                client_contact_dateupdated = '$currentDate'
            WHERE client_contact_id = '$contact_id'
            AND client_id = '$client_id'
        ";

    $contactResult = mysqli_query($conn, $updateContact);

  } else {

    // Insert new contact
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
  }

  if (!$contactResult) {

    mysqli_query($conn, "ROLLBACK");

    echo json_encode(array(
      'success' => false,
      'message' => 'Unable to save client contact details.'
    ));

    exit;
  }
}

// Delete contact records removed from the form
foreach ($existingContacts as $existingId) {

  if (!in_array($existingId, $submittedIds)) {

    $deleteContact = "
            DELETE FROM client_contact
            WHERE client_contact_id = '$existingId'
            AND client_id = '$client_id'
        ";

    $deleteResult = mysqli_query($conn, $deleteContact);

    if (!$deleteResult) {

      mysqli_query($conn, "ROLLBACK");

      echo json_encode(array(
        'success' => false,
        'message' => 'Unable to remove deleted contact details.'
      ));

      exit;
    }
  }
}

// Commit transaction
mysqli_query($conn, "COMMIT");

// Success response
echo json_encode(array(
  'success' => true,
  'message' => 'Client details and contact information have been successfully updated.'
));

$conn->close();
exit;
?>