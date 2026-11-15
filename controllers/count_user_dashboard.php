<?php
$page_title = 'Dashboard';

// USER STATISTICS
$total_users = 0;
$active_users = 0;
$inactive_users = 0;

$total_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM z_user");

if ($total_query) {
  $total_users = mysqli_fetch_assoc($total_query)['total'];
}

$active_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM z_user WHERE user_status = 'enabled'");

if ($active_query) {
  $active_users = mysqli_fetch_assoc($active_query)['total'];
}

$inactive_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM z_user WHERE user_status != 'enabled' OR user_status IS NULL");

if ($inactive_query) {
  $inactive_users = mysqli_fetch_assoc($inactive_query)['total'];
}

// RECENT USERS
$recent_query = mysqli_query($conn, "SELECT * FROM z_user ORDER BY user_id DESC LIMIT 5");

?>