<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
include 'config.php';
session_start();

// Get user ID
$user_id = $_SESSION['user_id'];
$other_user_id = $_GET['user_id']; // Get the other user's ID from URL parameter

// Function to send SSE data
function sendSSE($data) {
    echo "data: " . json_encode($data) . "\n\n";
    ob_flush();
    flush();
}

// Initial message data
$messages = [];
$select_messages = mysqli_query($conn, "SELECT * FROM `messages` WHERE (sender_id = '$user_id' AND receiver_id = '$other_user_id') OR (sender_id = '$other_user_id' AND receiver_id = '$user_id') ORDER BY timestamp") or die('query failed');
while($fetch_messages = mysqli_fetch_assoc($select_messages)){
    $messages[] = $fetch_messages;
}
sendSSE($messages); 

// Continuously check for new messages
while (true) {
    // Check for new messages for this user
    $new_messages_query = mysqli_query($conn, "SELECT * FROM `messages` WHERE (sender_id = '$user_id' AND receiver_id = '$other_user_id') OR (sender_id = '$other_user_id' AND receiver_id = '$user_id') AND timestamp > '{$messages[count($messages) - 1]['timestamp']}' ORDER BY timestamp"); // Check for new messages since the last fetched message

    if (mysqli_num_rows($new_messages_query) > 0) {
        $new_messages = [];
        while($fetch_new_messages = mysqli_fetch_assoc($new_messages_query)){
            $new_messages[] = $fetch_new_messages;
        }
        $messages = array_merge($messages,$new_messages); // Merge existing and new messages
        sendSSE($new_messages); // Send only new messages
    }

    sleep(1); // Check every 1 second
}
?>