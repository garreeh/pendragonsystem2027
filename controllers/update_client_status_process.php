<?php
session_start();

include './../connections/connections.php';

header('Content-Type: application/json');

date_default_timezone_set("Asia/Manila");

// Check request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(array(
    'success' => false,
    'message' => 'Invalid request.'
  ));
  exit;
}

// Check session
if (!isset($_SESSION['user_id'])) {
  echo json_encode(array(
    'success' => false,
    'message' => 'Your session has expired. Please log in again.'
  ));
  exit;
}

// Get submitted values
$client_id = isset($_POST['client_id']) ? (int) $_POST['client_id'] : 0;
$client_locked = isset($_POST['client_locked']) ? trim($_POST['client_locked']) : '';

// Validate client ID
if ($client_id <= 0) {
  echo json_encode(array(
    'success' => false,
    'message' => 'Invalid client account.'
  ));
  exit;
}

// Validate client status
if ($client_locked !== 'yes' && $client_locked !== 'no') {
  echo json_encode(array(
    'success' => false,
    'message' => 'Invalid client status.'
  ));
  exit;
}

// Prevent users from locking their own account
// if ($client_id == $_SESSION['client_id'] && $client_locked == 'yes') {
//   echo json_encode(array(
//     'success' => false,
//     'message' => 'You cannot lock your own account.'
//   ));
//   exit;
// }

// Check if user exists
$check_query = "
    SELECT client_id, client_locked
    FROM client
    WHERE client_id = '$client_id'
    LIMIT 1
";

$check_result = mysqli_query($conn, $check_query);

if (!$check_result || mysqli_num_rows($check_result) == 0) {
  echo json_encode(array(
    'success' => false,
    'message' => 'Client account not found.'
  ));
  mysqli_close($conn);
  exit;
}

$client_row = mysqli_fetch_assoc($check_result);

// Update client status
$update_query = "
    UPDATE client
    SET client_locked = '$client_locked'
    WHERE client_id = '$client_id'
";

$update_result = mysqli_query($conn, $update_query);

if ($update_result) {

  if ($client_locked == 'yes') {
    $message = 'Client account has been locked successfully.';
  } else {
    $message = 'Client account has been unlocked successfully.';
  }

  echo json_encode(array(
    'success' => true,
    'message' => $message,
    'client_id' => $client_id,
    'client_locked' => $client_locked
  ));

} else {

  echo json_encode(array(
    'success' => false,
    'message' => 'Unable to update client account status. Please try again.'
  ));

}

mysqli_close($conn);
exit;
?>