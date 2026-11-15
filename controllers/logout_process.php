<?php

include '../../connection/connections.php';
session_start();

// clear session data
session_unset();
session_destroy();

// redirect always
header("Location: /pendragonsystem2027/index.php");
exit();