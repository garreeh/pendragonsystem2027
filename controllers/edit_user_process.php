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
$user_id = isset($_POST['user_id']) ? (int) $_POST['user_id'] : 0;

$first_name = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
$last_name = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
$contact_no = isset($_POST['contact_no']) ? trim($_POST['contact_no']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$user_type_id = isset($_POST['user_type_id']) ? (int) $_POST['user_type_id'] : 0;

// Validate required fields
if (
  $user_id <= 0 ||
  $first_name === '' ||
  $last_name === '' ||
  $contact_no === '' ||
  $email === '' ||
  $username === '' ||
  $user_type_id <= 0
) {
  echo json_encode(array(
    'success' => false,
    'message' => 'Please complete all required fields.'
  ));
  exit;
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  echo json_encode(array(
    'success' => false,
    'message' => 'Please enter a valid email address.'
  ));
  exit;
}

// Sanitize and escape values
$first_name = $conn->real_escape_string(strip_tags($first_name));
$last_name = $conn->real_escape_string(strip_tags($last_name));
$contact_no = $conn->real_escape_string(strip_tags($contact_no));
$email = $conn->real_escape_string(strip_tags($email));
$username = $conn->real_escape_string(strip_tags($username));

// Check if user exists
$checkUser = "SELECT user_id FROM z_user WHERE user_id = '$user_id'";
$checkUserResult = mysqli_query($conn, $checkUser);

if (!$checkUserResult || mysqli_num_rows($checkUserResult) == 0) {
  echo json_encode(array(
    'success' => false,
    'message' => 'User record not found.'
  ));
  exit;
}

// Check duplicate username
$checkUsername = "
    SELECT user_id
    FROM z_user
    WHERE user_name = '$username'
    AND user_id != '$user_id'
";

$usernameResult = mysqli_query($conn, $checkUsername);

if (!$usernameResult) {
  echo json_encode(array(
    'success' => false,
    'message' => 'Unable to validate username.'
  ));
  exit;
}

if (mysqli_num_rows($usernameResult) > 0) {
  echo json_encode(array(
    'success' => false,
    'message' => 'Username is already being used by another account.'
  ));
  exit;
}

// Check duplicate email
$checkEmail = "
    SELECT user_id
    FROM z_user
    WHERE user_email = '$email'
    AND user_id != '$user_id'
";

$emailResult = mysqli_query($conn, $checkEmail);

if (!$emailResult) {
  echo json_encode(array(
    'success' => false,
    'message' => 'Unable to validate email address.'
  ));
  exit;
}

if (mysqli_num_rows($emailResult) > 0) {
  echo json_encode(array(
    'success' => false,
    'message' => 'Email address is already being used by another account.'
  ));
  exit;
}

// Validate User Type
$checkUserType = "
    SELECT user_type_id
    FROM z_user_restriction
    WHERE user_type_id = '$user_type_id'
";

$userTypeResult = mysqli_query($conn, $checkUserType);

if (!$userTypeResult || mysqli_num_rows($userTypeResult) == 0) {
  echo json_encode(array(
    'success' => false,
    'message' => 'Invalid User Type selected.'
  ));
  exit;
}

// Build UPDATE query
$sql = "
    UPDATE z_user SET
        user_firstname = '$first_name',
        user_lastname = '$last_name',
        user_contact = '$contact_no',
        user_email = '$email',
        user_name = '$username',
        user_type_id = '$user_type_id'
";

// Update password only if a new password was entered
if ($password !== '') {

  // Same salt key used by your login handler
  $salt = "CrazyassLongSALTThatMakesYourUsersPasswordVeryLong123!!312567__asdSdas";

  $hashed_password = hash('sha512', $salt . $password);

  $hashed_password = $conn->real_escape_string($hashed_password);

  $sql .= ",
        user_password = '$hashed_password'
    ";
}

// Complete UPDATE query
$sql .= "
    WHERE user_id = '$user_id'
";

// Execute query
$result = mysqli_query($conn, $sql);

if ($result) {

  echo json_encode(array(
    'success' => true,
    'message' => 'User details have been successfully updated.'
  ));

} else {

  echo json_encode(array(
    'success' => false,
    'message' => 'Unable to update user details. Please try again.'
  ));

}

$conn->close();
exit;
?>