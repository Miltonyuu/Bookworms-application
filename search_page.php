<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'already added to cart!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
      $message[] = 'product added to cart!';
   }

};

 // Check Verification Status
 $select_verification = mysqli_query($conn, "SELECT * FROM `verification_requests` WHERE user_id = '$user_id' AND status = 'approved'");
 $is_verified = mysqli_num_rows($select_verification) > 0; // True if verified

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>search page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>search page</h3>
   <p> <a href="home.php">home</a> / search </p>
</div>

<section class="search-form">
   <form action="" method="post">
      <input type="text" name="search" placeholder="Search products..." class="box">
      <input type="submit" name="submit" value="search" class="btn">
   </form>
</section>

<section class="products" style="padding-top: 0;">

<div class="box-container">
   <?php
      if(isset($_POST['submit'])){
         $search_item = $_POST['search'];
         $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE name LIKE '%{$search_item}%' OR author LIKE '%{$search_item}%'") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
         while($fetch_product = mysqli_fetch_assoc($select_products)){
         // Check if the product belongs to the logged-in user
          $user_id = $_SESSION['user_id'];
          $product_seller_id = $fetch_product['seller_id'];
   ?>
   <div class="box">
   <form action="" method="post">
      <img src="uploaded_img/<?php echo $fetch_product['image']; ?>" alt="" class="image">
      <div class="name"><?php echo $fetch_product['name']; ?></div>
      <div name="product_author" class="author">By: <?php echo $fetch_product['author']; ?></div>
      <div name="product_book_condi" class="book_condi">Book Condition: <?php echo $fetch_product['bookcondition']; ?></div>
      <div class="price">$<?php echo $fetch_product['price']; ?>/-</div>
      <input type="hidden"  class="qty" name="product_quantity" min="1" value="1">
      <?php if ($fetch_product['tradestatus'] == 'Yes'): ?>
              <div class="trading-container"> 
                  <img src="images/trading_logo.png" alt="Open for Trading" class="trading-logo">
                  <span class="trading-tooltip">This book is also open for trading</span>
              </div>
      <?php endif; ?>      
      <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
      <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
      <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
      <input type="hidden" class="btn" value="add to cart" name="add_to_cart" >
   </form>
   <?php


if ($user_id != $product_seller_id):?>
  <input type="hidden" min="2" name="product_quantity" value="1" class="qty"> <!--before(type="number")--> 
  
<form action="" method="post">
<input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
<input type="hidden" name="product_author" value="<?php echo $fetch_product['author']; ?>">
<input type="hidden" name="product_book_condi" value="<?php echo $fetch_product['bookcondition']; ?>">
<input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
<input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
<input type="hidden" min="2" name="product_quantity" value="1" class="qty">
<input type="submit" value="add to cart" name="add_to_cart" class="btn">
</form>

<div class="seller-info-container">
  <button class="contact-seller-btn btn" data-product-name="<?php echo $fetch_product['name']; ?>" data-seller-id="<?php echo $fetch_product['seller_id']; ?>">View User's Details</button>

  <div id="seller-info-popup" class="seller-popup-overlay">
    <div class="seller-popup-content">
      <span class="seller-close-btn">&times;</span>
      <div id="seller-details"></div>
    </div>
  </div>
</div>



<form action="contact_seller.php" method="post">
<input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
<input type="hidden" name="seller_id" value="<?php echo $fetch_product['seller_id']; ?>">
<input type="submit" value="contact seller" name="contact_seller" class="btn">
</form>
<?php endif; ?>         

   </div> <?php
            }
         }else{
            echo '<p class="empty">No result found!</p>';
         }
      }else{
         echo '<p class="empty">Search something!</p>';
      }
   ?>
   </div>
</section>









<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>