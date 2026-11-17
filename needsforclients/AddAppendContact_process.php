<?php

require_once('../connections/connections.php');
if (isset($_POST['client_contact_type']) && isset($_POST['client_contact_detail']) && isset($_POST['client_id'])) {
  $client_contact_type = $conn->real_escape_string(strip_tags($_POST['client_contact_type']));
  $client_contact_detail = $conn->real_escape_string(strip_tags($_POST['client_contact_detail']));
  $client_id = $_POST['client_id'];

  $sql = $conn->query("INSERT INTO `client_contact`(`client_contact_id`, `client_contact_type`, `client_contact_detail`, `client_id`) VALUES('','$client_contact_type', '$client_contact_detail', '$client_id')") or die(mysqli_error($conn));

  if ($sql == TRUE) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
         <strong>Insert Successfully!</strong>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
  } else {
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
         <strong>Insert Failed!</strong>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
  }
}

?>