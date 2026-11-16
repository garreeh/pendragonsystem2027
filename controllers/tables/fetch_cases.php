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

// Sorting
$columns = array(
  'c.case_id',
  'c.case_date',
  'p.patient_name',
  'cl.client_firstname',
  'p.`Attending Veterinarian`',
  'c.case_chief_complaint',
  'c.case_clinical_symptom',
  'c.case_laboratory_requested'
);

$columnIndex = isset($_POST['order'][0]['column'])
  ? intval($_POST['order'][0]['column'])
  : 0;

$orderColumn = isset($columns[$columnIndex])
  ? $columns[$columnIndex]
  : 'c.case_id';

$orderDirection = (
  isset($_POST['order'][0]['dir']) &&
  strtoupper($_POST['order'][0]['dir']) == 'ASC'
) ? 'ASC' : 'DESC';

// Search condition
$where = '';

if ($search !== '') {
  $where = " WHERE (
        CAST(c.case_id AS CHAR) LIKE '%$search%'
        OR c.case_date LIKE '%$search%'
        OR p.patient_name LIKE '%$search%'
        OR cl.client_firstname LIKE '%$search%'
        OR cl.client_lastname LIKE '%$search%'
        OR p.`Attending Veterinarian` LIKE '%$search%'
        OR c.case_chief_complaint LIKE '%$search%'
        OR c.case_clinical_symptom LIKE '%$search%'
        OR c.case_laboratory_requested LIKE '%$search%'
    )";
}

// Shared table joins
$tables = "
    FROM `case` c
    LEFT JOIN patient p ON c.patient_id = p.patient_id
    LEFT JOIN client cl ON p.client_id = cl.client_id
";

// Total records
$totalResult = mysqli_query(
  $conn,
  "SELECT COUNT(*) AS total FROM `case`"
);

$recordsTotal = intval(mysqli_fetch_assoc($totalResult)['total']);

// Filtered records
$filteredResult = mysqli_query(
  $conn,
  "SELECT COUNT(*) AS total $tables $where"
);

$recordsFiltered = intval(mysqli_fetch_assoc($filteredResult)['total']);

// Fetch records
$query = "
    SELECT
        c.case_id,
        c.case_date,
        p.patient_name,
        CONCAT(
            COALESCE(cl.client_firstname, ''),
            ' ',
            COALESCE(cl.client_lastname, '')
        ) AS owner_name,
        c.attendingvet AS attending_vet,
        c.case_chief_complaint,
        c.case_clinical_symptom,
        c.case_laboratory_requested

    $tables
    $where

    ORDER BY $orderColumn $orderDirection
    LIMIT $start, $length
";

$result = mysqli_query($conn, $query);

if (!$result) {
  error_log(mysqli_error($conn));
  http_response_code(500);
  echo json_encode(array('error' => 'Unable to retrieve cases.'));
  exit;
}

$data = array();

while ($row = mysqli_fetch_assoc($result)) {
  $data[] = $row;
}

// Response
echo json_encode(array(
  'draw' => $draw,
  'recordsTotal' => $recordsTotal,
  'recordsFiltered' => $recordsFiltered,
  'data' => $data
));
?>