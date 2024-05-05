<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

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

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="home">

   <div class="content">
   <h3>Unleash hidden gems in your bookshelf.</h3>
      <p>Discover new stories waiting to be loved. Buy, sell, and trade books in a thriving community.</p>
      <a href="about.php" class="white-btn">discover more</a>
   </div>

</section>

<section class="products">
  <h1 class="title">Listed Books</h1>
  <div class="box-container">

    <?php
       $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 6") or die('query failed');
       if(mysqli_num_rows($select_products) > 0){
         while($fetch_products = mysqli_fetch_assoc($select_products)){

           // Check if the product belongs to the logged-in user
           $user_id = $_SESSION['user_id']; 
           $product_seller_id = $fetch_products['seller_id']; // Assuming you have the seller_id

           ?>

         <form action="" method="post" class="box">
            <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
            <div class="name"><?php echo $fetch_products['name']; ?></div>
            <div class="price">₱<?php echo $fetch_products['price']; ?>/-</div>
            
            <?php 
               // Hide quantity if the logged-in user is the seller
               if($user_id != $product_seller_id):  
            ?> 
               <input type="number" min="1" name="product_quantity" value="1" class="qty">
            <?php 
               endif; 
            ?>

            <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">

            <?php 
               // Existing code for hiding "add to cart" and "contact seller" buttons
               if($user_id != $product_seller_id):  
            ?>
               <input type="submit" value="add to cart" name="add_to_cart" class="btn">
               <input type="submit" value="contact seller" name="contact_seller" class="btn">
            <?php 
               endif; 
            ?>
         </form>


      <?php
        }
     } else {
       echo '<p class="empty">no products added yet!</p>';
      }
    ?>
  </div>

  <div class="load-more" style="margin-top: 2rem; text-align:center">
      <a href="shop.php" class="option-btn">load more</a>
  </div>
</section>


<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/about-img.jpg" alt="">
      </div>

      <div class="content">
         <h3>about us</h3>
         <p>Looking for a new adventure? Explore a world of used books with Bookworms Connect! Buy, sell, and trade with other book lovers. It's like a treasure hunt for your bookshelf &#8209 find hidden gems and give your pre-loved stories a new home. All built by a TUP student who loves books just as much as you!</p>
         <a href="about.php" class="btn">read more</a>
      </div>

   </div>

</section>

<section class="home-contact">

   <div class="content">
      <h3>have any questions?</h3>
      <p> If you have any questions about buying, selling, or trading books on Bookworms Connect, feel free to browse our Help Center or contact our friendly support team. They're happy to assist you!</p>
      <a href="contact.php" class="white-btn">contact us</a>
   </div>

</section>





<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>