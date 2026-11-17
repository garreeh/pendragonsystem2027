<?php
require_once('../connections/connections.php');

if (isset($_POST["client_contact_id"])) {
  $query = "DELETE FROM `client_contact` WHERE client_contact_id = '" . $_POST['client_contact_id'] . "'";
  $sql = $conn->query($query);
  if ($sql === TRUE) {
    echo '<div>
             <script> setTimeout(function() {  window.history.go(-1); }, 200); </script>
          </div>';
  } else {
    echo "Error deleting record: " . $conn->error;
  }

}

?>