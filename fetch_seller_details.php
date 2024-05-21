<?php
include 'config.php';
$seller_id = $_GET['seller_id'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE id = $seller_id");
$seller_data = mysqli_fetch_assoc($query);

$verified = $seller_data['verified']; // 0 or 1

echo json_encode(array_merge($seller_data, ['verified' => $verified]))
?>
