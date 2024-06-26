<?php

include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
header('location:login.php');
}

// Initial Fetch of Existing Data (Before Updates)
$select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$user_id'") or die('query failed'); 
$fetch_user = mysqli_fetch_assoc($select_user);

// Check Verification Status
$select_verification = mysqli_query($conn, "SELECT * FROM `verification_requests` WHERE user_id = '$user_id' AND status = 'approved'");
$is_verified = mysqli_num_rows($select_verification) > 0; // True if verified


// Update logic
if(isset($_POST['update_profile'])){
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $birthdate = mysqli_real_escape_string($conn, $_POST['birthdate']);
  $bookshop_name = mysqli_real_escape_string($conn, $_POST['bookshop_name']);
  $contact_no = mysqli_real_escape_string($conn, $_POST['phone']);
  $bookwishlist1 = mysqli_real_escape_string($conn, $_POST['bookwishlist1']);
  $bookwishlist2 = mysqli_real_escape_string($conn, $_POST['bookwishlist2']);
  $gender = mysqli_real_escape_string($conn, $_POST['gender']);

  // Update the Database
  mysqli_query($conn, "UPDATE `users` SET name = '$name', email = '$email', birthdate = '$birthdate', bookshop_name = '$bookshop_name', contact_no = '$contact_no', bookwishlist1 = '$bookwishlist1', bookwishlist2 = '$bookwishlist2', gender = '$gender' WHERE id = '$user_id'") or die('query failed');
  
 $message[] = 'Profile updated successfully!'; // Add message to array
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Profile</title>
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
  </head>

<body class="user_profile">

<?php include 'header.php'; ?>

<section class="user-profile" style="margin-top:50px;">
<div class="form_wrapper">    
<?php
            $message = [];
            if(isset($message)){
              foreach($message as $message){
                echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.remove();"></i></div>';
                }
                }
                 ?>
  <div class="form_container">
    <div class="title_container">
      <h1 class="title">Update Your Profile Here</h1>
      <?php if ($is_verified): ?>
                    <i class="fas fa-check-circle verified-badge"></i> 
                <?php endif; ?> 
    </div>
    <div class="row clearfix">
      <div class="">
        <form action="" method="POST">
          <div class="input_field"> <span><i aria-hidden="true" class="fa fa-user"><p>Username</p></i></span>
            <input type="text" name="name" placeholder="Email" value="<?php echo $fetch_user['name']; ?>"/>
          </div>
          <div class="input_field"> <span><i aria-hidden="true" class="fa fa-envelope"><p>Email</p></i></span>
            <input type="email" name="email" placeholder="Email" value=" <?php echo $fetch_user['email']; ?>" />
          </div>
          <div class="input_field"> <span><i aria-hidden="true" class="fa fa-cake"><p>Birthday</p></i></span>
            <input type="date" name="birthdate"  value="<?php echo $fetch_user['birthdate']; ?>"/>
          </div>
          <div class="input_field"> <span><i aria-hidden="true" class="fa fa-lock"><p>Bookshop</p></i></span>
            <input type="text" name="bookshop_name" placeholder="Enter your bookshop name (optional)" value="<?php echo $fetch_user['bookshop_name']; ?>" />
          </div>
          <div class="input_field"> <span><i aria-hidden="true" class="fa fa-user"><p>Contact No.</p></i></span>
            <input type="number" name="phone" placeholder="Contact No." value="<?php echo $fetch_user['contact_no']; ?>"/>
          </div>
          <div class="input_field"> <span><i aria-hidden="true" class="fa fa-book"><p>Book Wishlist #1</p></i></span>
          <input type="text" name="bookwishlist1" placeholder="Book Wishlist 1" value="<?php echo $fetch_user['bookwishlist1']; ?>"/>
          </div>
          <div class="input_field"> <span><i aria-hidden="true" class="fa fa-book"><p>Book Wishlist #2</p></i></span>
          <input type="text" name="bookwishlist2" placeholder="Book Wishlist 2" value="<?php echo $fetch_user['bookwishlist2']; ?>"/>
          </div>
          <div class="input_field radio_option">
            <select name="gender" class="box">
                <option value="male" <?php if($fetch_user['gender'] == 'male') echo 'selected'; ?>>Male</option>
                <option value="female" <?php if($fetch_user['gender'] == 'female') echo 'selected'; ?>>Female</option>
            </select>  
          </div>
          <!--
            <div class="img_user" style="margin-bottom:5px">
              <h3>Image Profile</h3>
                <input type="file" name= "img_user">
          </div> 
          -->
          <input type="submit" value="Update" name="update_profile" class="button">
        </form>
      </div>
    </div>
  </div>
</div>
</section>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>