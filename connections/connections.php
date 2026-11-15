<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pendragondb";

// $servername = "localhost";
// $username = "u759574209_online_order";
// $password = "Mybossrocks081677!";
// $dbname = "u759574209_online_order";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    // echo "SUCCESS";
}
