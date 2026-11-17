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
  ? trim($_POST['search']['value'])
  : '';

$searchEscaped = mysqli_real_escape_string($conn, $search);

// Sorting
$columns = array(
  'c.case_id',
  'c.case_date',
  'p.patient_name',
  'cl.client_firstname',
  'c.attendingvet',
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

// Shared joins for patient and owner information
$tables = "
    FROM `case` c
    LEFT JOIN patient p
        ON c.patient_id = p.patient_id
    LEFT JOIN client cl
        ON p.client_id = cl.client_id
";

// Detect exact numeric Case ID search
$isCaseIdSearch = ($search !== '' && ctype_digit($search));

$caseIdSearch = 0;

if ($isCaseIdSearch) {
  $caseIdSearch = intval($search);
}

// Search condition
$where = '';

if ($isCaseIdSearch) {

  // Exact Case ID search
  $where = " WHERE c.case_id = " . $caseIdSearch;

} elseif ($search !== '') {

  // Text search
  $where = " WHERE (
        c.case_date LIKE '%$searchEscaped%'
        OR p.patient_name LIKE '%$searchEscaped%'
        OR cl.client_firstname LIKE '%$searchEscaped%'
        OR cl.client_lastname LIKE '%$searchEscaped%'
        OR c.attendingvet LIKE '%$searchEscaped%'
        OR c.case_chief_complaint LIKE '%$searchEscaped%'
        OR c.case_clinical_symptom LIKE '%$searchEscaped%'
        OR c.case_laboratory_requested LIKE '%$searchEscaped%'
    )";
}

// Total records
$totalResult = mysqli_query(
  $conn,
  "SELECT COUNT(*) AS total FROM `case`"
);

if (!$totalResult) {
  error_log(mysqli_error($conn));
  http_response_code(500);
  echo json_encode(array('error' => 'Unable to count cases.'));
  exit;
}

$totalRow = mysqli_fetch_assoc($totalResult);
$recordsTotal = intval($totalRow['total']);

// Filtered records
if ($where === '') {

  $recordsFiltered = $recordsTotal;

} else {

  // Skip joins for exact Case ID search
  if ($isCaseIdSearch) {

    $filteredQuery = "
            SELECT COUNT(*) AS total
            FROM `case` c
            $where
        ";

  } else {

    $filteredQuery = "
            SELECT COUNT(*) AS total
            $tables
            $where
        ";
  }

  $filteredResult = mysqli_query($conn, $filteredQuery);

  if (!$filteredResult) {
    error_log(mysqli_error($conn));
    http_response_code(500);
    echo json_encode(array('error' => 'Unable to filter cases.'));
    exit;
  }

  $filteredRow = mysqli_fetch_assoc($filteredResult);
  $recordsFiltered = intval($filteredRow['total']);
}

// Fetch records
if ($isCaseIdSearch) {

  // Exact Case ID: retrieve case first, then related details
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

        ORDER BY c.case_id $orderDirection

        LIMIT $start, $length
    ";

} else {

  // Normal listing and text search
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
}

$result = mysqli_query($conn, $query);

if (!$result) {
  error_log(mysqli_error($conn));
  http_response_code(500);
  echo json_encode(array('error' => 'Unable to retrieve cases.'));
  exit;
}

// Prepare DataTables response
$data = array();

while ($row = mysqli_fetch_assoc($result)) {
  $data[] = $row;
}

// JSON response
echo json_encode(array(
  'draw' => $draw,
  'recordsTotal' => $recordsTotal,
  'recordsFiltered' => $recordsFiltered,
  'data' => $data
));

?>