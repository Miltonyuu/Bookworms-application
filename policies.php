<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['send'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $number = $_POST['number'];
   $msg = mysqli_real_escape_string($conn, $_POST['message']);

   $select_message = mysqli_query($conn, "SELECT * FROM message WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'") or die('query failed');

   if(mysqli_num_rows($select_message) > 0){
      $message[] = 'message sent already!';
   }else{
      mysqli_query($conn, "INSERT INTO `message`(user_id, name, email, number, message) VALUES('$user_id', '$name', '$email', '$number', '$msg')") or die('query failed');
      $message[] = 'message sent successfully!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Policies</h3>
   <p> <a href="home.php">home</a> / policies </p>
</div>

<section class="policies">

      <h2 class="policies__title">Bookworms Connect Policies & Terms</h2>

      <div class="policies__content">

        <h3 class="policies__content__heading">Privacy Policy</h3>

        <p>
          We take user privacy seriously. This Privacy Policy outlines the information we collect, how we use it, and how you can manage your data.
        </p>

        <ul class="policies__content__list">
          <li><b>Information We Collect:</b> 
            <ul>
              <li>Usernames</li>
              <li>Email Addresses</li>
              <li>Contacts and Addresses (optional)</li>
              <li>Gallery Access (optional)</li>
              <li>Messaging Content</li>
              <li>IP Address and Device Information</li>
            </ul>
          </li>
          <li><b>Use of Information:</b> 
            <ul>
              <li>Account Management</li>
              <li>Communication</li>
              <li>Book Swap Facilitation (optional)</li>
              <li>Service Improvement</li>
            </ul>
          </li>
          <li><b>Sharing of Information:</b> 
            <ul>
              <li>Third-Party Service Providers</li>
              <li>Legal Requirements</li>
            </ul>
          </li>
          <li><b>User Rights:</b> 
            <ul>
              <li>Data Access and Update</li>
              <li>Account Deletion</li>
            </ul>
          </li>
          <li><b>Policy Updates:</b> We may update this policy. Changes will be communicated via email or website notice.</li>
        </ul>

        <h3 class="policies__content__heading">Terms of Service</h3>

        <p>
          By using Bookworms Connect, you agree to these terms. 
        </p>

        <ul class="policies__content__list">
          <li><b>Eligibility:</b> You must be 18 or older.</li>
          <li><b>User Conduct:</b> Respectful and legal behavior is expected. You will not engage in any activity that violates the rights of others or harms
          <li><b>Account Security:</b> You are responsible for maintaining the security of your account credentials. You will notify us immediately of any unauthorized access or use of your account.</li>
          <li><b>Intellectual Property:</b> You retain ownership of the content you upload to Bookworms Connect.</li>
          <li><b>Limitation of Liability:</b> We are not liable for any damages arising from your use of the platform. Additionally, Bookworms Connect is not liable for any failed book swaps or trades between users. Users are responsible for any agreements or transactions they make with other users on the platform..</li>








<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>