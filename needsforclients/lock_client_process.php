<?php
error_reporting(0);
require_once('../connections/connections.php');
if (isset($_POST['lock_client'])) {



    $client_id_locked = $conn->real_escape_string(strip_tags($_POST['client_id_locked']));

    $conn->query("UPDATE client
          SET 
              `client_locked` = 'yes'
             WHERE client_id = '$client_id_locked'");

    echo '<div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alerts">
               <strong>Successfully Update Client! </strong>
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">&times;</span>
              </button>
          <script> setTimeout(function() {  window.history.go(-1); }, 1000); </script> 
     </div>';
}
