<?php

include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
header('location:login.php');
}

if(isset($_POST['update_order'])){

$order_update_id = $_POST['order_id'];
$update_payment = $_POST['update_payment'];
mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_update_id'") or die('query failed');
$message[] = 'payment status has been updated!';

}

if(isset($_GET['delete_order'])){
$delete_id = $_GET['delete_order'];
mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
header('location:user_orders.php');
}

$order_status = '';
if (isset($_GET['status'])) {
$order_status = $_GET['status'];
}

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
<title>orders</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="css/admin_style.css">
<link rel="stylesheet" href="css/style.css">

</head>
<body>
<?php include 'header.php'; ?>

<section class="orders">

<h1 class="title">Selling Section</h1>

<div class="filters-container">  <div class="filter-buttons"> 
      <!--<a href="user_orders.php" class="option-btn <?php if($order_status == '') echo 'active'; ?>">All</a>-->
      <a href="user_orders.php?status=pending" class="option-btn <?php if($order_status == 'pending') echo 'active'; ?>">Pending</a>
      <a href="user_orders.php?status=completed" class="option-btn <?php if($order_status == 'completed') echo 'active'; ?>">Completed</a>
    </div>

<div class="box-container">
<?php
// Retrieve orders with filtering
$select_orders = mysqli_query($conn, "SELECT o.*, oi.quantity, p.name as product_name 
 FROM `orders` o
 JOIN `order_items` oi ON o.id = oi.order_id
 JOIN `products` p ON oi.product_id = p.id
 WHERE p.seller_id = '$user_id' 
        AND o.payment_status = '$order_status' -- Add filter if status is selected 
") or die('query failed'); 

if(mysqli_num_rows($select_orders) > 0){
 while($fetch_orders = mysqli_fetch_assoc($select_orders)){
 ?>
 <div class="box-for-selling">
<p> Buyer's Name : <span><?php echo $fetch_orders['buyer_name']; ?></span> </p>
 <p> <br>Buyer's Number : <span><?php echo $fetch_orders['number']; ?></span> </p>
<p> <br>Buyer's Email : <span><?php echo $fetch_orders['email']; ?></span> </p>
<p> <br>Buyer's Address : <span><?php echo $fetch_orders['address']; ?></span> </p>
 <p> <br>Total Products : <span><?php echo $fetch_orders['total_products']; ?></span> </p>
<p> <br>Total Price : <span>$<?php echo $fetch_orders['total_price']; ?>/-</span> </p>
 <p> <br>Payment Method : <span><?php echo $fetch_orders['method']; ?></span> </p>

<form action="" method="post">
<input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">

<br>
<select name="update_payment">
<option value="" selected disabled style="margin-top: 10px;"><?php echo $fetch_orders['payment_status']; ?></option>
<option value="pending">Pending</option>
<option value="completed">Completed</option>


 </select>
 <input type="submit" value="update" name="update_order" class="orders-option-btn">
 <a href="user_orders.php?delete_order=<?php echo $fetch_orders['id']; ?>" onclick="return confirm('Delete this order?');" class="delete-btn">Delete</a>
</form>
 </div>
<?php
}
 }else{
echo '<p class="empty">No orders placed yet!</p>';
}
?>
</div>

</section>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
