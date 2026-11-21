<?php
include_once("db_connect.php");

header("Content-Type: application/json; charset=UTF-8");

// Turn on full error reporting for debugging
error_reporting(E_ALL);
ini_set("display_errors", 1);
ini_set("log_errors", 1);
ini_set("error_log", __DIR__ . "/event_errors.log");

// Helper: ensure strings are valid UTF-8
function fix_utf8($str)
{
  if (!mb_check_encoding($str, 'UTF-8')) {
    $str = mb_convert_encoding($str, 'UTF-8', 'ISO-8859-1,Windows-1252');
  }
  return $str;
}

$sqlEvents = "SELECT * FROM appointment 
JOIN patient ON COALESCE(appointment.patient_id,'7006') = patient.patient_id 
JOIN client ON appointment.client_id = client.client_id 
WHERE appointment.appointment_datecreated >= '2025-01-01 09:30:00'";

$resultset = mysqli_query($conn, $sqlEvents);

if (!$resultset) {
  error_log("SQL ERROR: " . mysqli_error($conn));
  echo json_encode(["success" => 0, "error" => "SQL Query Failed"]);
  exit;
}

$calendar = [];

while ($rows = mysqli_fetch_assoc($resultset)) {

  // Fix all potential bad UTF-8 strings
  foreach ($rows as $key => $value) {
    $rows[$key] = fix_utf8($value);
  }

  $appointment_title = str_replace('-', ' ', $rows['appointment_description']);
  $appointment_title = fix_utf8($appointment_title);

  $appointmentstatus = fix_utf8($rows['appointment_status']);
  $patientname = fix_utf8($rows['patient_name']);
  $clientfname = fix_utf8($rows['client_firstname']);
  $clientlname = fix_utf8($rows['client_lastname']);
  $client = $clientfname . "," . $clientlname;

  $appointmenttime = trim(fix_utf8($rows['appointment_time']));
  $appointmenttimefix = ($appointmenttime == '1:0pm - 1:30pm')
    ? "1:00pm - 1:30pm"
    : $appointmenttime;

  $timesplit = explode(" - ", $appointmenttimefix, 2);

  if (count($timesplit) < 2 || trim($timesplit[0]) == '' || trim($timesplit[1]) == '') {
    error_log("Missing or invalid appointment time. Appointment ID: " . $rows['appointment_id'] . " | Time: " . $appointmenttime);
    continue;
  }

  $time1 = strtotime(trim($timesplit[0]));
  $time2 = strtotime(trim($timesplit[1]));

  if ($time1 === false || $time2 === false) {
    error_log("Invalid appointment time format. Appointment ID: " . $rows['appointment_id']);
    continue;
  }

  $appointmenttimesplit1 = date('H:i:s', $time1);
  $appointmenttimesplit2 = date('H:i:s', $time2);

  $appointmentschedule = $rows['appointment_schedule'];

  date_default_timezone_set("Asia/Manila");
  $appointmentstartdate = date('Y-m-d H:i:s', strtotime("$appointmentschedule $appointmenttimesplit1"));
  $appointmentenddate = date('Y-m-d H:i:s', strtotime("$appointmentschedule $appointmenttimesplit2"));

  $start = strtotime($appointmentstartdate) * 1000;
  $end = strtotime($appointmentenddate) * 1000;

  $color = ($appointmentstatus == 'paid') ? "event-important" : "event-warning";

  // Construct title safely
  $title = $patientname . "---" .
    $appointmenttimesplit1 . "-" . $appointmenttimesplit2 . "---" .
    ucwords($appointment_title) . "---" .
    $client . "---" .
    $appointmentstatus . "---Pager number:" . $rows['pager_number'];

  // Encode title safely
  $title = fix_utf8($title);

  // Build event
  $calendar[] = [
    'id' => $rows['appointment_id'],
    'title' => $title,
    'url' => "http://app.pendragonvet.com/pendragonsystem2019/views/viewPatient.php?patient_id=" . $rows['patient_id'],
    'class' => $color,
    'start' => $start,
    'end' => $end
  ];
}

$calendarData = [
  "success" => 1,
  "result" => $calendar
];

// Encode JSON with error checking
$json = json_encode($calendarData);

if (!$json) {
  error_log("JSON ENCODING ERROR: " . json_last_error_msg());
  error_log("RAW DATA CAUSING ERROR: " . print_r($calendarData, true));

  echo json_encode([
    "success" => 0,
    "error" => "JSON encoding failed: " . json_last_error_msg()
  ]);
  exit;
}

// Output final JSON
echo $json;
exit;
