<?php
session_start();
include './../connections/connections.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode([
    'success' => false,
    'message' => 'Invalid request.'
  ]);
  exit;
}

date_default_timezone_set("Asia/Manila");
$date = date("M-d-Y h:i A");

$user = isset($_POST['full_name']) ? $_POST['full_name'] : '';
$pass = isset($_POST['password']) ? $_POST['password'] : '';

$user1 = $conn->real_escape_string(strip_tags($user));
$password = $conn->real_escape_string(strip_tags($pass));

if (empty($user1) || empty($password)) {
  echo json_encode([
    'success' => false,
    'message' => 'Please enter your username and password.'
  ]);
  exit;
}

$salt = "CrazyassLongSALTThatMakesYourUsersPasswordVeryLong123!!312567__asdSdas";
$pass1 = hash('sha512', $salt . $password);

$sql = "SELECT * FROM z_user WHERE user_name = '$user1' AND user_password = '$pass1'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {

  $row = $result->fetch_assoc();

  // Check user account status
  if ($row['user_status'] !== 'enabled') {
    echo json_encode([
      'success' => false,
      'message' => 'Your account is currently inactive. Please contact your administrator to activate your account before logging in.'
    ]);

    $conn->close();
    exit;
  }

  // Regenerate session ID
  session_regenerate_id(true);

  $_SESSION['user_id'] = htmlentities($row['user_id']);
  $_SESSION['user_name'] = htmlentities($row['user_name']);
  $_SESSION['user_type_id'] = htmlentities($row['user_type_id']);
  $_SESSION['user_firstname'] = htmlentities($row['user_firstname']);
  $_SESSION['user_lastname'] = htmlentities($row['user_lastname']);
  $_SESSION['user_status'] = htmlentities($row['user_status']);

  // Remember Me
  if (!empty($_POST['remember'])) {
    setcookie("user_name", $user1, time() + (10 * 365 * 24 * 60 * 60), "/");
    setcookie("user_password", $password, time() + (10 * 365 * 24 * 60 * 60), "/");
  } else {
    setcookie("user_name", "", time() - 3600, "/");
    setcookie("user_password", "", time() - 3600, "/");
  }

  echo json_encode([
    'success' => true,
    'message' => 'Successfully logged in! Welcome back.',
    'redirect' => 'views/dashboard.php'
  ]);

} else {

  echo json_encode([
    'success' => false,
    'message' => 'Login failed. Please check your username and password.'
  ]);

}

$conn->close();
exit;
?>