<?php

include './../../connections/connections.php';

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

header('Content-Type: application/json; charset=utf-8');

// Authentication
if (!isset($_SESSION['user_id'])) {
  http_response_code(401);

  echo json_encode(array(
    'error' => 'Unauthorized.'
  ));

  exit;
}


// ======================================
// DATATABLES PARAMETERS
// ======================================

$draw = isset($_POST['draw']) ? intval($_POST['draw']) : 0;

$start = isset($_POST['start'])
  ? max(0, intval($_POST['start']))
  : 0;

$length = isset($_POST['length'])
  ? intval($_POST['length'])
  : 10;

if ($length < 1 || $length > 100) {
  $length = 10;
}


// ======================================
// SEARCH
// ======================================

$search = isset($_POST['search']['value'])
  ? trim($_POST['search']['value'])
  : '';

$where = '';

$isClientIdSearch = false;
$clientIdSearch = 0;

if ($search !== '') {

  // Numeric search: exact Client ID lookup
  if (ctype_digit($search)) {

    $isClientIdSearch = true;
    $clientIdSearch = intval($search);

    $where = " WHERE client_id = $clientIdSearch";

  } else {

    // Text search
    $searchEscaped = mysqli_real_escape_string($conn, $search);

    $where = " WHERE (
            client_firstname LIKE '%$searchEscaped%'
            OR client_lastname LIKE '%$searchEscaped%'
            OR CONCAT(
                COALESCE(client_firstname, ''),
                ' ',
                COALESCE(client_lastname, '')
            ) LIKE '%$searchEscaped%'
            OR client_datecreated LIKE '%$searchEscaped%'
        )";

  }
}


// ======================================
// SORTING COLUMNS
// ======================================

$columns = array(
  'client_id',
  'client_firstname',
  'client_datecreated'
);

$columnIndex = isset($_POST['order'][0]['column'])
  ? intval($_POST['order'][0]['column'])
  : 0;

$orderColumn = isset($columns[$columnIndex])
  ? $columns[$columnIndex]
  : 'client_id';

$orderDirection = (
  isset($_POST['order'][0]['dir']) &&
  strtoupper($_POST['order'][0]['dir']) == 'ASC'
) ? 'ASC' : 'DESC';


// ======================================
// TOTAL RECORDS
// ======================================

$totalQuery = mysqli_query(
  $conn,
  "SELECT COUNT(*) AS total FROM client"
);

if (!$totalQuery) {

  error_log(mysqli_error($conn));

  http_response_code(500);

  echo json_encode(array(
    'error' => 'Unable to count client records.'
  ));

  exit;
}

$totalRow = mysqli_fetch_assoc($totalQuery);

$recordsTotal = intval($totalRow['total']);


// ======================================
// FILTERED RECORDS
// ======================================

if ($isClientIdSearch) {

  // Exact ID count using PRIMARY KEY
  $filteredQuery = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
         FROM client
         WHERE client_id = $clientIdSearch"
  );

} else {

  $filteredQuery = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
         FROM client
         $where"
  );

}

if (!$filteredQuery) {

  error_log(mysqli_error($conn));

  http_response_code(500);

  echo json_encode(array(
    'error' => 'Unable to filter client records.'
  ));

  exit;
}

$filteredRow = mysqli_fetch_assoc($filteredQuery);

$recordsFiltered = intval($filteredRow['total']);


// ======================================
// FETCH PAGINATED CLIENT RECORDS
// ======================================

$query = "
    SELECT
        client_id,
        client_firstname,
        client_lastname,

        CONCAT(
            COALESCE(client_firstname, ''),
            ' ',
            COALESCE(client_lastname, '')
        ) AS full_name,

        client_datecreated,
        COALESCE(client_locked, 'no') AS client_locked

    FROM client

    $where

    ORDER BY $orderColumn $orderDirection

    LIMIT $start, $length
";

$result = mysqli_query($conn, $query);

if (!$result) {

  error_log(mysqli_error($conn));

  http_response_code(500);

  echo json_encode(array(
    'error' => 'Unable to retrieve client records.'
  ));

  exit;
}


// ======================================
// BUILD DATA ARRAY
// ======================================

$data = array();

while ($row = mysqli_fetch_assoc($result)) {

  $data[] = $row;

}


// ======================================
// DATATABLES JSON RESPONSE
// ======================================

echo json_encode(array(
  'draw' => $draw,
  'recordsTotal' => $recordsTotal,
  'recordsFiltered' => $recordsFiltered,
  'data' => $data
));

?>