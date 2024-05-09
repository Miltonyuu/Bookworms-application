<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_GET['user_id'])){
    $user_two_id = $_GET['user_id'];
}

if(isset($_POST['send'])){
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    if($message != ""){ // Ensure the message isn't empty 
        mysqli_query($conn, "INSERT INTO `messages`(sender_id, receiver_id, message, timestamp) VALUES('$user_id', '$user_two_id', '$message', NOW())") or die('query failed');
    } 
    header('location:chat.php?user_id='.$user_two_id); // Refresh after sending
}

$select_user_two = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$user_two_id'") or die('query failed'); 
if(mysqli_num_rows($select_user_two) > 0){
    $fetch_user_two = mysqli_fetch_assoc($select_user_two);

    // Profile Image Check
    $profile_image = (file_exists("uploaded_img/".$fetch_user_two['image']) &&  $fetch_user_two['image'] != "") ? "uploaded_img/".$fetch_user_two['image'] : "images/default_profile.png"; 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Chat</title>
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

<section class="chat" style="margin-top:100px">

   <h1 class="title">Chat Section</h1>

   <div class="chat-box">
       <?php
            // Fetch the name of the user you are chatting with   
           $select_user_two = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$user_two_id'") or die('query failed'); 
           if(mysqli_num_rows($select_user_two) > 0){
               $fetch_user_two = mysqli_fetch_assoc($select_user_two);
           }
       ?>
       <div style="display:block;">
       <span><h3>Chatting with:<?php echo $fetch_user_two['name'] ?></h3></span> 
       <span><img src="<?php echo $profile_image; ?>" alt="Profile Image" class="profile-pic"></span>
       </div>


       <?php
           $select_messages = mysqli_query($conn, "SELECT * FROM `messages` WHERE (sender_id = '$user_id' AND receiver_id = '$user_two_id') OR  (sender_id = '$user_two_id' AND receiver_id = '$user_id') ORDER BY timestamp") or die('query failed');

           if(mysqli_num_rows($select_messages) > 0){
               while($fetch_messages = mysqli_fetch_assoc($select_messages)){
                if($fetch_messages['sender_id'] == $user_id){ 
                    echo '<div class="msg you"><img src="' . $profile_image . '" alt="Profile Image" class="profile-pic-small"> ' . $fetch_messages['message'] . '</div>';
                }else{ 
                    echo '<div class="msg other"><img src="' . $profile_image . '" alt="Profile Image" class="profile-pic-small"> ' . $fetch_messages['message'] . '</div>';
                }      
               } 
           } else {
               echo "<p class='empty'>Start the conversation!</p>";
           }
       ?>
   </div>

<div>
<form action="" method="post" class="send-message">
       <input type="text" name="message" class="box" placeholder="enter message">
       <input type="submit" name="send" value="send" class="btn">
   </form>
</div>


</section>

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>
<script src="js/admin_script.js"></script>


</body>
</html>
