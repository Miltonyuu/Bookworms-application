<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location:login.php');
}

if(isset($_POST['contact_seller'])){

  // Optional - Sanitize input to prevent malicious code
  $product_name = mysqli_real_escape_string($conn, $_POST['product_name']); 
  $seller_id = mysqli_real_escape_string($conn, $_POST['seller_id']);
  $name =  isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : ''; // Add checks for other fields
  $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : ''; 
  $number = isset($_POST['number']) ? mysqli_real_escape_string($conn, $_POST['number']) : ''; 
  $message = isset($_POST['message']) ? mysqli_real_escape_string($conn, $_POST['message']) : ''; 

    $select_seller = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$seller_id'"); 
    if(mysqli_num_rows($select_seller) > 0){
        $fetch_seller = mysqli_fetch_assoc($select_seller);
        $seller_email = $fetch_seller['email'];

        $insert_message = mysqli_query($conn, "INSERT INTO `messages`(sender_id, receiver_id, message) VALUES('$user_id', '$seller_id', 'Contact request regarding product: $product_name. My details - Name: $name, Email: $email, Number: $number, Message: $message')") or die('query failed'); 

        // Replace with the actual code to send the email
      mail($seller_email, 'New contact request', "You have received a contact request regarding your product: $product_name from: $name (Email: $email, Number: $number). Message: $message", 'From: ' . $email);
       $message[] = 'Message sent successfully!';
    
    } else {
        $message[] = 'Seller not found!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   </head>
<body>
  
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

    <?php include 'header.php'; ?> 

    <section class="contact-form">
    <h1 class="title">Contact Seller</h1>
    <form action="" method="post">
        <input type="text" name="name" placeholder="Enter your name" class="box" required/>
        <input type="email" name="email" placeholder="Enter your email" class="box" required/>
        <input type="submit" name="contact_seller" class="btn" value="Send Message"/> 
    </form>
</section>


    <?php include 'footer.php'; ?> 
    </body>
</html>
