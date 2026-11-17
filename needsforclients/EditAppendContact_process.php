<?php

require_once('../connections/connections.php');
if (isset($_POST['client_contact_id'])) {
  $client_contact_type = $conn->real_escape_string(strip_tags($_POST['client_contact_type']));
  $client_contact_detail = $conn->real_escape_string(strip_tags($_POST['client_contact_detail']));
  $client_id = $conn->real_escape_string(strip_tags($_POST['client_id']));
  $client_contact_id = $conn->real_escape_string(strip_tags($_POST['client_contact_id']));
  $sql = $conn->query("UPDATE `client_contact`
               SET 
              `client_contact_type` = '$client_contact_type',
              `client_contact_detail` = '$client_contact_detail',
              `client_id` = '$client_id'     
             WHERE client_contact_id = '$client_contact_id'");

  if ($sql == TRUE) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
         <strong>Update Successfully!</strong>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
  } else {
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
         <strong>Update Failed!</strong>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
  }
}

?>