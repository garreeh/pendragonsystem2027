<?php
ob_start();
error_reporting(0);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

require_once('../connections/connections.php');

if (isset($_POST['client_submit'])) {

  $clientlastname = $conn->real_escape_string(strip_tags($_POST['client_lastname']));
  $clientfirstname = $conn->real_escape_string(strip_tags($_POST['client_firstname']));
  $clientaddress = $conn->real_escape_string(strip_tags($_POST['client_address']));
  date_default_timezone_set("asia/manila");
  $clientdatecreated = date('Y-m-d', strtotime("+0 HOURS"));
  $clientremarks = $conn->real_escape_string(strip_tags($_POST['client_remarks']));
  $clientstreetno = $conn->real_escape_string(strip_tags($_POST['client_streetno']));
  $clientstreet = $conn->real_escape_string(strip_tags($_POST['client_street']));
  $clientbarangay = $conn->real_escape_string(strip_tags($_POST['client_barangay']));
  $clientdistrict = $conn->real_escape_string(strip_tags($_POST['client_district']));
  $clientcity = $conn->real_escape_string(strip_tags($_POST['client_city']));
  $clientprovince = $conn->real_escape_string(strip_tags($_POST['client_province']));
  $clientzip = $conn->real_escape_string(strip_tags($_POST['client_zip']));

  $conn->query("INSERT INTO `client` (client_id, client_lastname, client_firstname, client_address, client_datecreated, client_remarks, client_streetno, client_street, client_barangay, client_district, client_city, client_province, client_zip) VALUES ('', '$clientlastname', '$clientfirstname', '$clientaddress', '$clientdatecreated', '$clientremarks', '$clientstreetno', '$clientstreet', '$clientbarangay', '$clientdistrict', '$clientcity', '$clientprovince', '$clientzip')");

  $last_id = mysqli_insert_id($conn); //last insert id fetch second table this is foreign key by:junil
  $dropdown = $_POST['client_contact_type'];
  $clientcontactdetail = $_POST['client_contact_detail'];

  date_default_timezone_set("asia/manila");
  $clientdatecreated = date('Y-m-d', strtotime("+0 HOURS"));
  $clientdateupdated = date('Y-m-d', strtotime("+0 HOURS"));

  for ($i = 0; $i < count($dropdown); $i++) {

    $conn->query("INSERT INTO `client_contact`(client_contact_id, client_contact_type, client_contact_detail, client_contact_datecreated, client_contact_dateupdated, client_id) VALUES ('','$dropdown[$i]','$clientcontactdetail[$i]', '$clientdatecreated', '$clientdateupdated', '$last_id')");
  }

  echo '<div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alerts">
                    <strong>Successfully Registered Client! </strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
               </button>
                    <script> setTimeout(function() {  window.history.go(-2); }, 1000); </script> 
               </div>';

}
