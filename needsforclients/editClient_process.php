<?php
error_reporting(0);
require_once('../connections/connections.php');
if (isset($_POST['client_edit'])) {

  $clientid = $conn->real_escape_string(strip_tags($_POST['client_id']));
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



  $conn->query("UPDATE client
          SET 
              `client_id` = '$clientid',
              `client_lastname` = '$clientlastname',
              `client_firstname` = '$clientfirstname',
              `client_address` = '$clientaddress',
              `client_datecreated` = '$clientdatecreated',
              `client_remarks` = '$clientremarks',
              `client_streetno` = '$clientstreetno',
              `client_street` = '$clientstreet',
              `client_barangay` = '$clientbarangay',
              `client_district` = '$clientdistrict',
              `client_city` = '$clientcity',
              `client_province` = '$clientprovince',
              `client_zip` = '$clientzip'

            
             WHERE client_id = '$_REQUEST[client_id]'");



  echo '<div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alerts">
               <strong>Successfully Update Client! </strong>
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">&times;</span>
              </button>
          <script> setTimeout(function() {  window.history.go(-1); }, 1000); </script> 
     </div>';

}
