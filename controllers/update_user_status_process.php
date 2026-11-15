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
$user_id = isset($_POST['user_id']) ? (int) $_POST['user_id'] : 0;
$user_status = isset($_POST['user_status']) ? trim($_POST['user_status']) : '';

// Validate user ID
if ($user_id <= 0) {
  echo json_encode(array(
    'success' => false,
    'message' => 'Invalid user account.'
  ));
  exit;
}

// Validate user status
if ($user_status !== 'enabled' && $user_status !== 'disabled') {
  echo json_encode(array(
    'success' => false,
    'message' => 'Invalid user status.'
  ));
  exit;
}

// Prevent users from locking their own account
if ($user_id == $_SESSION['user_id'] && $user_status == 'disabled') {
  echo json_encode(array(
    'success' => false,
    'message' => 'You cannot lock your own account.'
  ));
  exit;
}

// Check if user exists
$check_query = "
    SELECT user_id, user_status
    FROM z_user
    WHERE user_id = '$user_id'
    LIMIT 1
";

$check_result = mysqli_query($conn, $check_query);

if (!$check_result || mysqli_num_rows($check_result) == 0) {
  echo json_encode(array(
    'success' => false,
    'message' => 'User account not found.'
  ));
  mysqli_close($conn);
  exit;
}

$user_row = mysqli_fetch_assoc($check_result);

// Update user status
$update_query = "
    UPDATE z_user
    SET user_status = '$user_status'
    WHERE user_id = '$user_id'
";

$update_result = mysqli_query($conn, $update_query);

if ($update_result) {

  if ($user_status == 'disabled') {
    $message = 'User account has been locked successfully.';
  } else {
    $message = 'User account has been unlocked successfully.';
  }

  echo json_encode(array(
    'success' => true,
    'message' => $message,
    'user_id' => $user_id,
    'user_status' => $user_status
  ));

} else {

  echo json_encode(array(
    'success' => false,
    'message' => 'Unable to update user account status. Please try again.'
  ));

}

mysqli_close($conn);
exit;
?>