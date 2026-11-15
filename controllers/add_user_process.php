<?php
session_start();
include './../connections/connections.php';

header('Content-Type: application/json');

date_default_timezone_set("Asia/Manila");

// Check request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode([
    'success' => false,
    'message' => 'Invalid request.'
  ]);
  exit;
}

// Check user session
if (!isset($_SESSION['user_id'])) {
  echo json_encode([
    'success' => false,
    'message' => 'Your session has expired. Please log in again.'
  ]);
  exit;
}

// Get POST values
$first_name = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
$last_name = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
$contact_no = isset($_POST['contact_no']) ? trim($_POST['contact_no']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$user_type_id = isset($_POST['user_type_id']) ? trim($_POST['user_type_id']) : '';
$user_status = isset($_POST['user_status']) ? trim($_POST['user_status']) : '';

// Check required fields
if (
  empty($first_name) ||
  empty($last_name) ||
  empty($contact_no) ||
  empty($email) ||
  empty($username) ||
  empty($password) ||
  empty($user_type_id) ||
  empty($user_status)
) {
  echo json_encode([
    'success' => false,
    'message' => 'Please complete all required fields.'
  ]);
  exit;
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  echo json_encode([
    'success' => false,
    'message' => 'Please enter a valid email address.'
  ]);
  exit;
}

// Validate user status
if (!in_array($user_status, array('enabled', 'disabled'), true)) {
  echo json_encode([
    'success' => false,
    'message' => 'Invalid user status.'
  ]);
  exit;
}

// Validate user type ID
if (!ctype_digit($user_type_id)) {
  echo json_encode([
    'success' => false,
    'message' => 'Invalid user type.'
  ]);
  exit;
}

// Sanitize inputs
$first_name = $conn->real_escape_string(strip_tags($first_name));
$last_name = $conn->real_escape_string(strip_tags($last_name));
$contact_no = $conn->real_escape_string(strip_tags($contact_no));
$email = $conn->real_escape_string($email);
$username = $conn->real_escape_string(strip_tags($username));
$user_type_id = $conn->real_escape_string($user_type_id);
$user_status = $conn->real_escape_string($user_status);

// Hash password using the same salt as login
$salt = "CrazyassLongSALTThatMakesYourUsersPasswordVeryLong123!!312567__asdSdas";

$hashed_password = hash('sha512', $salt . $password);

// Check if username already exists
$check_username = "
    SELECT user_id
    FROM z_user
    WHERE user_name = '$username'
    LIMIT 1
";

$username_result = mysqli_query($conn, $check_username);

if (!$username_result) {
  echo json_encode([
    'success' => false,
    'message' => 'Unable to validate username.'
  ]);
  exit;
}

if (mysqli_num_rows($username_result) > 0) {
  echo json_encode([
    'success' => false,
    'message' => 'Username already exists. Please choose another username.'
  ]);
  exit;
}

// Check if email already exists
$check_email = "
    SELECT user_id
    FROM z_user
    WHERE user_email = '$email'
    LIMIT 1
";

$email_result = mysqli_query($conn, $check_email);

if (!$email_result) {
  echo json_encode([
    'success' => false,
    'message' => 'Unable to validate email address.'
  ]);
  exit;
}

if (mysqli_num_rows($email_result) > 0) {
  echo json_encode([
    'success' => false,
    'message' => 'Email address is already registered.'
  ]);
  exit;
}

// Check if user type exists
$check_user_type = "
    SELECT user_type_id
    FROM z_user_restriction
    WHERE user_type_id = '$user_type_id'
    LIMIT 1
";

$type_result = mysqli_query($conn, $check_user_type);

if (!$type_result || mysqli_num_rows($type_result) == 0) {
  echo json_encode([
    'success' => false,
    'message' => 'Selected user type does not exist.'
  ]);
  exit;
}

// Insert new user
$sql = "
    INSERT INTO z_user (
        user_firstname,
        user_lastname,
        user_contact,
        user_email,
        user_name,
        user_password,
        user_type_id,
        user_status
    ) VALUES (
        '$first_name',
        '$last_name',
        '$contact_no',
        '$email',
        '$username',
        '$hashed_password',
        '$user_type_id',
        '$user_status'
    )
";

if (mysqli_query($conn, $sql)) {

  echo json_encode([
    'success' => true,
    'message' => 'User successfully added!'
  ]);

} else {

  echo json_encode([
    'success' => false,
    'message' => 'Failed to add user. Please try again.'
  ]);

}

mysqli_close($conn);
exit;
?>