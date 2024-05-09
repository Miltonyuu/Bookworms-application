<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

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
           $select_messages = mysqli_query($conn, "SELECT * FROM `messages` WHERE sender_id = '$user_id' OR receiver_id = '$user_id' GROUP BY sender_id, receiver_id ORDER BY timestamp DESC") or die('query failed');
           if(mysqli_num_rows($select_messages) > 0){
               while($fetch_messages = mysqli_fetch_assoc($select_messages)){
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
