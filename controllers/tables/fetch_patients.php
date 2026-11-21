<?php
include './../../connections/connections.php';

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['user_id'])) {
  http_response_code(401);
  header('Content-Type: application/json');

  echo json_encode(array(
    "error" => "Unauthorized access."
  ));
  exit();
}

header('Content-Type: application/json');

// DataTables parameters
$draw = isset($_POST['draw']) ? intval($_POST['draw']) : 0;
$start = isset($_POST['start']) ? intval($_POST['start']) : 0;
$length = isset($_POST['length']) ? intval($_POST['length']) : 10;

if ($start < 0) {
  $start = 0;
}

if ($length < 1 || $length > 100) {
  $length = 10;
}

// Search
$search = '';

if (isset($_POST['search']['value'])) {
  $search = trim($_POST['search']['value']);
}

$searchEscaped = mysqli_real_escape_string($conn, $search);

// Allowed sorting columns
$columns = array(
  0 => 'p.patient_id',
  1 => 'p.patient_microchip',
  2 => 'p.patient_name',
  3 => 'cl.client_firstname',
  4 => 's.species_name',
  5 => 'b.breed_name'
);

$orderColumn = 'p.patient_id';
$orderDirection = 'DESC';

if (isset($_POST['order'][0]['column'])) {
  $columnIndex = intval($_POST['order'][0]['column']);

  if (isset($columns[$columnIndex])) {
    $orderColumn = $columns[$columnIndex];
  }
}

if (isset($_POST['order'][0]['dir'])) {
  $direction = strtolower($_POST['order'][0]['dir']);

  $orderDirection = ($direction == 'asc') ? 'ASC' : 'DESC';
}

// Base joins
$baseQuery = "
    FROM patient p

    LEFT JOIN client cl
        ON p.client_id = cl.client_id

    LEFT JOIN species s
        ON p.species_id = s.species_id

    LEFT JOIN breed b
        ON p.breed_id = b.breed_id
";

// Total records
$totalQuery = "
    SELECT COUNT(*) AS total
    $baseQuery
";

$totalResult = mysqli_query($conn, $totalQuery);

if (!$totalResult) {
  echo json_encode(array(
    "draw" => $draw,
    "recordsTotal" => 0,
    "recordsFiltered" => 0,
    "data" => array(),
    "error" => mysqli_error($conn)
  ));
  exit();
}

$totalRow = mysqli_fetch_assoc($totalResult);
$recordsTotal = intval($totalRow['total']);

// Search conditions
$where = '';

if ($search != '') {

  if (is_numeric($search)) {
    $patientId = intval($search);

    $where = "
            WHERE
                p.patient_id = $patientId
                OR p.patient_microchip LIKE '%$searchEscaped%'
                OR p.patient_name LIKE '%$searchEscaped%'
                OR cl.client_firstname LIKE '%$searchEscaped%'
                OR cl.client_lastname LIKE '%$searchEscaped%'
                OR CONCAT(
                    COALESCE(cl.client_firstname, ''),
                    ' ',
                    COALESCE(cl.client_lastname, '')
                ) LIKE '%$searchEscaped%'
                OR s.species_name LIKE '%$searchEscaped%'
                OR b.breed_name LIKE '%$searchEscaped%'
        ";

  } else {

    $where = "
            WHERE
                p.patient_microchip LIKE '%$searchEscaped%'
                OR p.patient_name LIKE '%$searchEscaped%'
                OR cl.client_firstname LIKE '%$searchEscaped%'
                OR cl.client_lastname LIKE '%$searchEscaped%'
                OR CONCAT(
                    COALESCE(cl.client_firstname, ''),
                    ' ',
                    COALESCE(cl.client_lastname, '')
                ) LIKE '%$searchEscaped%'
                OR s.species_name LIKE '%$searchEscaped%'
                OR b.breed_name LIKE '%$searchEscaped%'
        ";
  }
}

// Filtered records
$filteredQuery = "
    SELECT COUNT(*) AS total
    $baseQuery
    $where
";

$filteredResult = mysqli_query($conn, $filteredQuery);

if (!$filteredResult) {
  echo json_encode(array(
    "draw" => $draw,
    "recordsTotal" => $recordsTotal,
    "recordsFiltered" => 0,
    "data" => array(),
    "error" => mysqli_error($conn)
  ));
  exit();
}

$filteredRow = mysqli_fetch_assoc($filteredResult);
$recordsFiltered = intval($filteredRow['total']);

// Fetch patient records
$dataQuery = "
    SELECT
        p.patient_id,
        p.patient_microchip,
        p.patient_name,

        CONCAT(
            COALESCE(cl.client_firstname, ''),
            ' ',
            COALESCE(cl.client_lastname, '')
        ) AS owner_fullname,

        s.species_name,
        b.breed_name

    $baseQuery
    $where

    ORDER BY $orderColumn $orderDirection

    LIMIT $start, $length
";

$dataResult = mysqli_query($conn, $dataQuery);

if (!$dataResult) {
  echo json_encode(array(
    "draw" => $draw,
    "recordsTotal" => $recordsTotal,
    "recordsFiltered" => $recordsFiltered,
    "data" => array(),
    "error" => mysqli_error($conn)
  ));
  exit();
}

$data = array();

while ($row = mysqli_fetch_assoc($dataResult)) {
  $data[] = $row;
}

// DataTables response
echo json_encode(array(
  "draw" => $draw,
  "recordsTotal" => $recordsTotal,
  "recordsFiltered" => $recordsFiltered,
  "data" => $data
));

?>