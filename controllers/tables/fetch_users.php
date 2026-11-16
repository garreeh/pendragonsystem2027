<?php
include './../../connections/connections.php';

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

header('Content-Type: application/json; charset=utf-8');

// Authentication
if (!isset($_SESSION['user_id'])) {
  http_response_code(401);
  echo json_encode(array('error' => 'Unauthorized.'));
  exit;
}

// DataTables parameters
$draw = isset($_POST['draw']) ? intval($_POST['draw']) : 0;
$start = isset($_POST['start']) ? max(0, intval($_POST['start'])) : 0;
$length = isset($_POST['length']) ? intval($_POST['length']) : 10;

if ($length < 1 || $length > 100) {
  $length = 10;
}

// Search
$search = isset($_POST['search']['value'])
  ? mysqli_real_escape_string($conn, trim($_POST['search']['value']))
  : '';

// Sorting columns
$columns = array(
  'user_id',
  'user_firstname',
  'user_name',
  'user_email',
  'user_status'
);

$columnIndex = isset($_POST['order'][0]['column'])
  ? intval($_POST['order'][0]['column'])
  : 0;

$orderColumn = isset($columns[$columnIndex])
  ? $columns[$columnIndex]
  : 'user_id';

$orderDirection = (
  isset($_POST['order'][0]['dir']) &&
  strtoupper($_POST['order'][0]['dir']) == 'ASC'
) ? 'ASC' : 'DESC';

// Search condition
$where = '';

if ($search !== '') {
  $where = " WHERE (
        CAST(user_id AS CHAR) LIKE '%$search%'
        OR user_firstname LIKE '%$search%'
        OR user_lastname LIKE '%$search%'
        OR CONCAT(user_firstname, ' ', user_lastname) LIKE '%$search%'
        OR user_name LIKE '%$search%'
        OR user_email LIKE '%$search%'
        OR user_status LIKE '%$search%'
    )";
}

// Total records
$totalQuery = mysqli_query(
  $conn,
  "SELECT COUNT(*) AS total FROM z_user"
);

if (!$totalQuery) {
  error_log(mysqli_error($conn));
  http_response_code(500);
  echo json_encode(array('error' => 'Unable to count users.'));
  exit;
}

$totalRow = mysqli_fetch_assoc($totalQuery);
$recordsTotal = intval($totalRow['total']);

// Filtered records
$filteredQuery = mysqli_query(
  $conn,
  "SELECT COUNT(*) AS total FROM z_user $where"
);

if (!$filteredQuery) {
  error_log(mysqli_error($conn));
  http_response_code(500);
  echo json_encode(array('error' => 'Unable to filter users.'));
  exit;
}

$filteredRow = mysqli_fetch_assoc($filteredQuery);
$recordsFiltered = intval($filteredRow['total']);

// Fetch paginated users
$query = "
    SELECT
        user_id,
        user_firstname,
        user_lastname,
        CONCAT(
            COALESCE(user_firstname, ''),
            ' ',
            COALESCE(user_lastname, '')
        ) AS full_name,
        user_name,
        user_email,
        COALESCE(user_status, 'enabled') AS user_status
    FROM z_user
    $where
    ORDER BY $orderColumn $orderDirection
    LIMIT $start, $length
";

$result = mysqli_query($conn, $query);

if (!$result) {
  error_log(mysqli_error($conn));
  http_response_code(500);
  echo json_encode(array('error' => 'Unable to retrieve users.'));
  exit;
}

$data = array();

while ($row = mysqli_fetch_assoc($result)) {
  $data[] = $row;
}

// DataTables response
echo json_encode(array(
  'draw' => $draw,
  'recordsTotal' => $recordsTotal,
  'recordsFiltered' => $recordsFiltered,
  'data' => $data
));
?>