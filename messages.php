<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

 // Check Verification Status
 $select_verification = mysqli_query($conn, "SELECT * FROM `verification_requests` WHERE user_id = '$user_id' AND status = 'approved'");
 $is_verified = mysqli_num_rows($select_verification) > 0; // True if verified

// More code to follow... 
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Messages</title>
   <link rel="stylesheet" href="css/admin_style.css">  
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- custom css file link  -->
<link rel="stylesheet" href="css/style.css">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'header.php'; ?>


<section style="margin-top:100px" class="messages">
    <h1 class="title">Your Messages</h1>
    <div class="box-container-messages">
        <?php
            // Refactored query to fetch the latest message in each conversation
            $select_messages = mysqli_query($conn, 
            "SELECT m1.*
            FROM messages m1
            INNER JOIN (
                SELECT 
                    CASE WHEN sender_id = '$user_id' THEN receiver_id ELSE sender_id END AS other_user_id,
                    MAX(timestamp) AS latest_timestamp
                FROM messages
                WHERE sender_id = '$user_id' OR receiver_id = '$user_id'
                GROUP BY other_user_id
            ) m2 ON (
                (m1.sender_id = '$user_id' AND m1.receiver_id = m2.other_user_id) OR 
                (m1.receiver_id = '$user_id' AND m1.sender_id = m2.other_user_id)
            ) AND m1.timestamp = m2.latest_timestamp
            ORDER BY timestamp DESC");

            if (mysqli_num_rows($select_messages) > 0) {
                while ($fetch_messages = mysqli_fetch_assoc($select_messages)) {
                    // Determine if user is the 'sender' or 'receiver'
                    $user_to_chat_with = ($fetch_messages['sender_id'] == $user_id) ? $fetch_messages['receiver_id'] : $fetch_messages['sender_id'];

                    // Fetch user to chat with details
                    $select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$user_to_chat_with'") or die('query failed');
                    $fetch_user = mysqli_fetch_assoc($select_user);
        ?>
        <div class="box-user">
            <p> <i class="fas fa-user"></i> <span><?php echo $fetch_user['name']; ?></span> </p>
            <a href="chat.php?user_id=<?php echo $fetch_user['id']; ?>" class="btn">Message</a>
        </div>
        <?php 
                }
            } else {
                echo "<p class='empty'>You have no messages yet!</p>";
            }
        ?>  
    </div>
</section>

   


<?php include 'footer.php'; ?>

<script src="js/script.js"></script>
<script src="js/admin_script.js"></script>




</body>
</html>
