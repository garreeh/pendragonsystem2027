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
  'user_type_id',
  'user_type_name',
  'case_doctor'
);

$columnIndex = isset($_POST['order'][0]['column'])
  ? intval($_POST['order'][0]['column'])
  : 0;

$orderColumn = isset($columns[$columnIndex])
  ? $columns[$columnIndex]
  : 'user_type_id';

$orderDirection = (
  isset($_POST['order'][0]['dir']) &&
  strtoupper($_POST['order'][0]['dir']) == 'ASC'
) ? 'ASC' : 'DESC';

// Search condition
$where = '';

if ($search !== '') {
  $where = " WHERE (
        CAST(user_type_id AS CHAR) LIKE '%$search%'
        OR user_type_name LIKE '%$search%'
        OR case_doctor LIKE '%$search%'
    )";
}

// Total records
$totalQuery = mysqli_query(
  $conn,
  "SELECT COUNT(*) AS total FROM z_user_restriction"
);

if (!$totalQuery) {
  error_log(mysqli_error($conn));
  http_response_code(500);
  echo json_encode(array('error' => 'Unable to count user roles.'));
  exit;
}

$totalRow = mysqli_fetch_assoc($totalQuery);
$recordsTotal = intval($totalRow['total']);

// Filtered records
$filteredQuery = mysqli_query(
  $conn,
  "SELECT COUNT(*) AS total FROM z_user_restriction $where"
);

if (!$filteredQuery) {
  error_log(mysqli_error($conn));
  http_response_code(500);
  echo json_encode(array('error' => 'Unable to filter user roles.'));
  exit;
}

$filteredRow = mysqli_fetch_assoc($filteredQuery);
$recordsFiltered = intval($filteredRow['total']);

// Fetch paginated user roles
$query = "
    SELECT
        user_type_id,
        user_type_name,
        COALESCE(case_doctor, 'enabled') AS case_doctor
    FROM z_user_restriction
    $where
    ORDER BY $orderColumn $orderDirection
    LIMIT $start, $length
";

$result = mysqli_query($conn, $query);

if (!$result) {
  error_log(mysqli_error($conn));
  http_response_code(500);
  echo json_encode(array('error' => 'Unable to retrieve user roles.'));
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