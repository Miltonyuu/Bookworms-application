<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_POST['order_btn'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $number = $_POST['number'];
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $address = mysqli_real_escape_string($conn, 'flat no. ' . $_POST['flat'] . ', ' . $_POST['street'] . ', ' . $_POST['city'] . ', ' . $_POST['country'] . ' - ' . $_POST['pin_code']);
    $placed_on = date('d-M-Y');

    $cart_total = 0;
    $cart_products = []; // Use a simple array

    // Fetch cart items for this user (including product_id and quantity)
    $cart_query = mysqli_query($conn, "SELECT products.*, cart.quantity AS cart_quantity FROM `cart` JOIN products ON cart.name = products.name WHERE cart.user_id = '$user_id'") or die('query failed');

    if (mysqli_num_rows($cart_query) > 0) {
        while ($cart_item = mysqli_fetch_assoc($cart_query)) {
            $cart_products[] = $cart_item; 
            $cart_total += ($cart_item['price'] * $cart_item['cart_quantity']); 
        }
    }

    // Separate orders by seller
    $orders_by_seller = [];
    foreach ($cart_products as $item) {
        $seller_id = $item['seller_id']; 
        if (!isset($orders_by_seller[$seller_id])) {
            $orders_by_seller[$seller_id] = [];
        }
        $orders_by_seller[$seller_id][] = $item; 
    }

    // Process each order group
    foreach ($orders_by_seller as $seller_id => $seller_cart_products) {
        $total_products = implode(', ', array_map(function ($item) {
            return $item['name'] . ' (' . $item['cart_quantity'] . ')'; // Use 'cart_quantity'
        }, $seller_cart_products));

        // Calculate total for this seller's items
        $seller_cart_total = 0;
        foreach ($seller_cart_products as $item) {
            $seller_cart_total += ($item['price'] * $item['cart_quantity']);  // Use 'cart_quantity'
        }

        // Fetch buyer's name
        $buyer_query = mysqli_query($conn, "SELECT name FROM users WHERE id = '$user_id'"); 
        $buyer_data = mysqli_fetch_assoc($buyer_query); 
        $buyer_name = $buyer_data['name']; 

        // Insert into 'orders' table (include seller_id)
        mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on, buyer_id, buyer_name, seller_id) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$seller_cart_total', '$placed_on', '$user_id', '$buyer_name', '$seller_id')") or die('query failed');
        $order_id = mysqli_insert_id($conn);

        // Insert items into 'order_items' table
        foreach ($seller_cart_products as $item) { 
            mysqli_query($conn, "INSERT INTO `order_items` (order_id, product_id, quantity) VALUES ('$order_id', '{$item['id']}', '{$item['cart_quantity']}')") or die('query failed'); // Use 'cart_quantity'
        }
    }
    
    $message[] = 'order placed successfully!';
    // Clear the cart for this user AFTER processing all orders
    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
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
            $total_price = ($fetch_cart['price'] * $fetch_cart['qUantity']);
            $grand_total += $total_price;
   ?>
   <p> <?php echo $fetch_cart['name']; ?> <span>(<?php echo '$'.$fetch_cart['price'].'/-'.' x '. $fetch_cart['qUantity']; ?>)</span> </p>
   <?php
      }
   }else{
      echo '<p class="empty">your cart is empty</p>';
   }
   ?>
   <div class="grand-total"> Grand Total : <span>$<?php echo $grand_total; ?>/-</span> </div>

</section>

<section class="checkout">

   <form action="" method="post">
      <h3>place your order</h3>
      <div class="flex">
         <div class="inputBox">
            <span>Your Name :</span>
            <input type="text" name="name" required placeholder="Enter your name">
         </div>
         <div class="inputBox">
            <span>Your Number :</span>
            <input type="number" name="number" required placeholder="Enter your number">
         </div>
         <div class="inputBox">
            <span>Your Email :</span>
            <input type="email" name="email" required placeholder="Enter your email">
         </div>
         <div class="inputBox">
            <span>Payment Method :</span>
            <select name="method">
               <option value="cash on delivery">Cash on Delivery</option>
               <option value="credit card">Credit Card</option>
               <option value="paypal">Paypal</option>
               <option value="paytm">Paytm</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Address line 01 :</span>
            <input type="number" min="0" name="flat" required placeholder="e.g. Flat No.">
         </div>
         <div class="inputBox">
            <span>Address line 01 :</span>
            <input type="text" name="street" required placeholder="e.g. Street Name">
         </div>
         <div class="inputBox">
            <span>City :</span>
            <input type="text" name="city" required placeholder="e.g. Mumbai City">
         </div>
         <div class="inputBox">
            <span>State :</span>
            <input type="text" name="state" required placeholder="e.g. Maharashtra">
         </div>
         <div class="inputBox">
            <span>Country :</span>
            <input type="text" name="country" required placeholder="e.g. India">
         </div>
         <div class="inputBox">
            <span>Pin Code :</span>
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