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


<?php
    if (isset($_SESSION['user_id'])) { 
        $user_id = $_SESSION['user_id']; 
        render_cart($user_id); // Pass $user_id
         // Check Verification Status
   $select_verification = mysqli_query($conn, "SELECT * FROM `verification_requests` WHERE user_id = '$user_id' AND status = 'approved'");
   $is_verified = mysqli_num_rows($select_verification) > 0; // True if verified

    } 
?>



<link rel="stylesheet" href="./css/style.css">

<header class="header">
<!--
   <div class="header-1">
      <div class="flex">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
         </div>
         <p> <a href="login.php">Login</a> | <a href="register.php">Register</a> </p>
      </div>
   </div>
   -->
   <div class="header-2">
      <div class="flex">
         <a href="home.php" class="logo">Bookworms Connect.</a>

         <nav class="navbar">
         <a href="home.php"class="button-34" id="special-color">Home</a>
            <a href="shop.php"class="button-34" id="special-color">Shop</a>
            <a href="user_products.php"class="button-34" id="special-color">Listing</a>
            <a href="user_orders.php"class="button-34" id="special-color">Sales</a>
            <a href="orders.php"class="button-34" id="special-color">Orders</a>
            <a href="messages.php"class="button-34" id="special-color">Messages</a>
            <a href="verify_user.php"class="button-34" id="special-color">Verification</a>
            
            
         </nav>

         <div class="icons" style="display:flex; margin:0;">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
            <?php
            
            function render_cart($user_id) { // Accept $user_id as a parameter
               global $conn; 
               $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
               $cart_rows_number = mysqli_num_rows($select_cart_number); 
               return $cart_rows_number; // Return the cart count
           }
           
               
            ?>
          <div class="icons" style="display:flex; margin:0;">
               <?php 
                     if (isset($_SESSION['user_id'])) {
                        $user_id = $_SESSION['user_id'];
                        $cart_rows_number = render_cart($user_id); // Call the function and store the result
               ?>
               <a href="cart.php"> <i class="fas fa-shopping-cart"></i> <span>(<?php echo $cart_rows_number; ?>)</span> </a>
               <?php } ?>  
               </div>

         </div>

         <div class="user-box" style="margin:0;">
            <div class="for_tooltip">
               <?php if ($is_verified): ?>
                  <div class="user_tooltip">This User is Verified</div><i class="fas fa-check-circle verified-badge"></i>
               <?php endif; ?>
            </div>
            <p>Username:  <span><?php echo $_SESSION['user_name']; ?></span></p>
            <p>Email:  <span><?php echo $_SESSION['user_email']; ?></span></p>
            <a href="user_profile.php" class="profile-btn">Profile Details</a>
            <a href="logout.php" class="logout-btn">logout</a>
         </div>
      </div>
   </div>

</header>