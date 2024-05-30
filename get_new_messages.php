<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];
$other_user_id = $_GET['user_id'];

// Get messages since the last timestamp
$last_timestamp = $_GET['last_timestamp'] / 1000; 
$query = mysqli_query($conn, "SELECT * FROM `messages` 
    WHERE ((sender_id = '$user_id' AND receiver_id = '$other_user_id') 
        OR (sender_id = '$other_user_id' AND receiver_id = '$user_id')) 
        AND UNIX_TIMESTAMP(timestamp) > '$last_timestamp'
    ORDER BY timestamp") or die('query failed: ' . mysqli_error($conn));
$new_messages = [];
while($fetch_messages = mysqli_fetch_assoc($query)){
    $new_messages[] = $fetch_messages;
}

// Send JSON response
echo json_encode($new_messages);
?>
