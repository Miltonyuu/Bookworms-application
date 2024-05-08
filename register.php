<?php

include 'config.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $gender = $_POST['gender'];
   $user_type = $_POST['user_type'];
   $birthday = $_POST['birthday'];

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){
      $message[] = 'user already exist!';
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }else{
         mysqli_query($conn, "INSERT INTO `users`(name, email, password, gender, birthdate, user_type) VALUES('$name', '$email', '$cpass', '$gender', '$birthday', '$user_type')") or die('query failed');
         $message[] = 'registered successfully!';
         header('location:login.php');
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>



<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
   
<div class="form-container">

   <form action="" method="post">
      <h3>Register now</h3>
      <p required class="name">Full Name</p>
      <input type="text" name="name" placeholder="enter your name" required class="box">
      <p required class="email">Email Address</p>
      <input type="email" name="email" placeholder="enter your email" required class="box">
      <p required class="password">Password</p>
      <input type="password" name="password" placeholder="enter your password" required class="box">
      <input type="password" name="cpassword" placeholder="confirm your password" required class="box">
      <p required class="gender">Gender</p>
      <select name="gender" class="box">
         <option value="" selected disabled>Select Gender</option>
         <option value="male">Male</option>
         <option value="female">Female</option>
      </select>
      <p required class="type">Role Type</p>
      <select name="user_type" class="box">
         <option value="" selected disabled>Select Type</option>
         <option value="user">User</option>
         <option value="admin">Admin</option>
      </select>
      <p required class="dateofbirth">Date of Birth</p>
      <input type="date" name="birthday" required class="box">
      <input type="submit" name="submit" value="register now" class="btn">
      <p>Already have an account? <a href="login.php">Login now</a></p>
   </form>

</div>

</body>
</html>