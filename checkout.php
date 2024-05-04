<?php

include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
header('location:login.php');
}

if(isset($_POST['order_btn'])){

$name = mysqli_real_escape_string($conn, $_POST['name']);
$number = $_POST['number'];
$email = mysqli_real_escape_string($conn, $_POST['email']);
$method = mysqli_real_escape_string($conn, $_POST['method']);
$address = mysqli_real_escape_string($conn, 'flat no. '. $_POST['flat'].', '. $_POST['street'].', '. $_POST['city'].', '. $_POST['country'].' - '. $_POST['pin_code']);
$placed_on = date('d-M-Y');


$cart_total = 0;
$cart_products[] = '';

$cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
if(mysqli_num_rows($cart_query) > 0){
while($cart_item = mysqli_fetch_assoc($cart_query)){
$cart_products[] = $cart_item['name'].' ('.$cart_item['quantity'].') ';
$sub_total = ($cart_item['price'] * $cart_item['quantity']);
$cart_total += $sub_total;
}
}

$total_products = implode(', ',$cart_products);

$order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');

if($cart_total == 0){
 $message[] = 'your cart is empty';
}else{
if(mysqli_num_rows($order_query) > 0){
$message[] = 'order already placed!'; 
 }else{

   $buyer_query = mysqli_query($conn, "SELECT name FROM users WHERE id = '$user_id'"); 
   if (mysqli_num_rows($buyer_query) > 0) {
       $buyer_data = mysqli_fetch_assoc($buyer_query); 
       $buyer_name = $buyer_data['name'];
   } else {
       $buyer_name = "Buyer Name Not Found"; 
   }
   

// Insert into 'orders' table
mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on, buyer_id, buyer_name) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on', '$user_id', '$buyer_name')") or die('query failed');

// Get the order ID of the newly inserted order
 $order_id = mysqli_insert_id($conn); 

// Insert items into 'order_items' table 
foreach ($cart_products as $product_name_quantity) {
   // Extract product details (name, quantity)
   $parts = explode('(', $product_name_quantity); // Split to get name & quantity
   $product_name = trim($parts[0]);
 
   if (isset($parts[1])) { // Check if the second part exists
       $quantity_str = trim(substr($parts[1], 0, -1)); 
       $quantity = intval($quantity_str);
   } else {
       $quantity = 1; // Set a default quantity if the format is wrong
   }
 
   // Get product_id (assuming you have a 'products' table)
   $product_id_query = mysqli_query($conn, "SELECT id FROM products WHERE name = '$product_name'");
   if (mysqli_num_rows($product_id_query) > 0) { // Check if the product exists
       $product_id_data = mysqli_fetch_assoc($product_id_query);
       $product_id = $product_id_data['id'];
   } else {
       // Handle product not found (e.g., set default or log error)
       $product_id = null; // Or any other handling you prefer 
   }
 
 
   // Insert into 'order_items'
   mysqli_query($conn, "INSERT INTO `order_items` (order_id, product_id, quantity) VALUES ('$order_id', '$product_id', '$quantity')") or die('query failed'); 
 }
 
$message[] = 'order placed successfully!';
mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
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
   <title>checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>checkout</h3>
   <p> <a href="home.php">home</a> / checkout </p>
</div>

<section class="display-order">

   <?php  
      $grand_total = 0;
      $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select_cart) > 0){
         while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $total_price;
   ?>
   <p> <?php echo $fetch_cart['name']; ?> <span>(<?php echo '$'.$fetch_cart['price'].'/-'.' x '. $fetch_cart['quantity']; ?>)</span> </p>
   <?php
      }
   }else{
      echo '<p class="empty">your cart is empty</p>';
   }
   ?>
   <div class="grand-total"> grand total : <span>$<?php echo $grand_total; ?>/-</span> </div>

</section>

<section class="checkout">

   <form action="" method="post">
      <h3>place your order</h3>
      <div class="flex">
         <div class="inputBox">
            <span>your name :</span>
            <input type="text" name="name" required placeholder="enter your name">
         </div>
         <div class="inputBox">
            <span>your number :</span>
            <input type="number" name="number" required placeholder="enter your number">
         </div>
         <div class="inputBox">
            <span>your email :</span>
            <input type="email" name="email" required placeholder="enter your email">
         </div>
         <div class="inputBox">
            <span>payment method :</span>
            <select name="method">
               <option value="cash on delivery">cash on delivery</option>
               <option value="credit card">credit card</option>
               <option value="paypal">paypal</option>
               <option value="paytm">paytm</option>
            </select>
         </div>
         <div class="inputBox">
            <span>address line 01 :</span>
            <input type="number" min="0" name="flat" required placeholder="e.g. flat no.">
         </div>
         <div class="inputBox">
            <span>address line 01 :</span>
            <input type="text" name="street" required placeholder="e.g. street name">
         </div>
         <div class="inputBox">
            <span>city :</span>
            <input type="text" name="city" required placeholder="e.g. mumbai">
         </div>
         <div class="inputBox">
            <span>state :</span>
            <input type="text" name="state" required placeholder="e.g. maharashtra">
         </div>
         <div class="inputBox">
            <span>country :</span>
            <input type="text" name="country" required placeholder="e.g. india">
         </div>
         <div class="inputBox">
            <span>pin code :</span>
            <input type="number" min="0" name="pin_code" required placeholder="e.g. 123456">
         </div>
      </div>
      <input type="submit" value="order now" class="btn" name="order_btn">
   </form>

</section>









<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>