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
    } 
?>


<header class="header">

   <div class="header-1">
      <div class="flex">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <p> new <a href="login.php">login</a> | <a href="register.php">register</a> </p>
      </div>
   </div>

   <div class="header-2">
      <div class="flex">
         <a href="home.php" class="logo">Bookworms Connect.</a>

         <nav class="navbar">
            <a href="home.php">home</a>
            <a href="about.php">about</a>
            <a href="shop.php">shop</a>
            <a href="contact.php">contact</a>
            <a href="orders.php">buys</a>
            <a href="user_orders.php">selling</a>
            <a href="user_products.php">products</a>
            
         </nav>

         <div class="icons">
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
          <div class="icons">
               <?php 
                     if (isset($_SESSION['user_id'])) {
                        $user_id = $_SESSION['user_id'];
                        $cart_rows_number = render_cart($user_id); // Call the function and store the result
               ?>
               <a href="cart.php"> <i class="fas fa-shopping-cart"></i> <span>(<?php echo $cart_rows_number; ?>)</span> </a>
               <?php } ?>  
               </div>

         </div>

         <div class="user-box">
            <p>username : <span><?php echo $_SESSION['user_name']; ?></span></p>
            <p>email : <span><?php echo $_SESSION['user_email']; ?></span></p>
            <a href="user_profile.php" class="profile-btn">Profile Details</a>
            <a href="logout.php" class="logout-btn">logout</a>
         </div>
      </div>
   </div>

</header>