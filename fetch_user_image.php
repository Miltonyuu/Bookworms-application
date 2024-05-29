<?php
include 'config.php';

if (isset($_GET['user_id'])) {
  $userId = $_GET['user_id'];

  $query = mysqli_query($conn, "SELECT image FROM users WHERE id = $userId");
  if (mysqli_num_rows($query) > 0) {
    $userData = mysqli_fetch_assoc($query);
    echo json_encode($userData);
  } else {
    echo json_encode(array('error' => 'User not found'));
  }
} else {
  echo json_encode(array('error' => 'Invalid request'));
}
