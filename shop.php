<?php

include 'config.php';

session_start();

$email = $_SESSION['user_email'];
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_author = $_POST['product_author'];
   $product_book_condi = $_POST['product_book_condi'];
   $product_price = $_POST['product_price'];
   $product_quantity = $_POST['product_quantity'];
   $product_image = $_POST['product_image'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'already added to cart!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, author, bookcondition, price, qUantity, image) VALUES('$user_id', '$product_name', '$product_author', '$product_book_condi', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
      $message[] = 'product added to cart!';
   }

    // Check Verification Status
    $select_verification = mysqli_query($conn, "SELECT * FROM `verification_requests` WHERE user_id = '$user_id' AND status = 'approved'");
    $is_verified = mysqli_num_rows($select_verification) > 0; // True if verified

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shop</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>our shop</h3>
   <p> <a href="home.php">home</a> / shop </p>
</div>

<section class="products">
  <h1 class="title">Available Books</h1>
  <div class="box-container">
    <?php
      $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE name != 'Verification Subscription'") or die('query failed');
      if (mysqli_num_rows($select_products) > 0) {
        while ($fetch_products = mysqli_fetch_assoc($select_products)) {
          // Check if the product belongs to the logged-in user
          $user_id = $_SESSION['user_id'];
          $product_seller_id = $fetch_products['seller_id'];

          ?>

          <div class="box">
            <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
            <div class="name"><?php echo $fetch_products['name']; ?></div>
            <div name="product_author" class="author">By: <?php echo $fetch_products['author']; ?></div>
            <div name="product_book_condi" class="book_condi">Book Condition: <?php echo $fetch_products['bookcondition']; ?></div>
            <div class="price">₱<?php echo $fetch_products['price']; ?>/-</div>
            <?php
                if ($user_id != $product_seller_id):?>
                  <input type="number" min="2" name="product_quantity" value="1" class="qty">
                  
              <form action="" method="post">
                <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                <input type="hidden" name="product_author" value="<?php echo $fetch_products['author']; ?>">
                <input type="hidden" name="product_book_condi" value="<?php echo $fetch_products['bookcondition']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                <input type="hidden" min="2" name="product_quantity" value="1" class="qty">
                <input type="submit" value="add to cart" name="add_to_cart" class="btn">
              </form>

              <form action="view_seller.php" method="post">
              <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
              <input type="hidden" name="seller_id" value="<?php echo $fetch_products['seller_id']; ?>">
              <div class="view_seller_info"><input type="submit" value="View Seller's Details" name="view_seller" class="btn"></div>
              </form>

              <form action="contact_seller.php" method="post">
                <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                <input type="hidden" name="seller_id" value="<?php echo $fetch_products['seller_id']; ?>">
                <input type="submit" value="contact seller" name="contact_seller" class="btn">
              </form>
            <?php endif; ?>

          </div>  <?php
        }
      } else {
        echo '<p class="empty">no products added yet!</p>';
      }
    ?>
  </div>
</section>



<?php include 'footer.php'; ?> 

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>