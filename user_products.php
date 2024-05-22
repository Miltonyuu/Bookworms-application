<?php

include 'config.php'; 
session_start();

$user_id = $_SESSION['user_id'];
$seller_user_name = $_SESSION['user_name'];
$email = $_SESSION['user_email'];

if(!isset($user_id)){
header('location:login.php');
};

if(isset($_POST['add_product'])){

$name = mysqli_real_escape_string($conn, $_POST['name']);
$author_input = $_POST['author']; // Example: 'Bobby\'s Pizza'
$escaped_author = mysqli_real_escape_string($conn, $author_input);
$price = $_POST['price'];
$bookcondition = $_POST['bookcondi'];
$image = $_FILES['image']['name'];
$image_size = $_FILES['image']['size'];
$image_tmp_name = $_FILES['image']['tmp_name'];
$image_folder = 'uploaded_img/'.$image;
$tradestatus = $_POST['tradestatus'];
$isbn = $_POST['isbn'];

$select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE name = '$name'") or die('query failed');

if(mysqli_num_rows($select_product_name) > 0){
 $message[] = 'product name already added';
}else{
 $add_product_query = mysqli_query($conn, "INSERT INTO `products`(name, author, price, bookcondition, tradestatus, isbn, image, seller_id) VALUES('$name', '$escaped_author', '$price', '$bookcondition','$tradestatus', '$isbn' , '$image', '$user_id')") or die('query failed');

 if($add_product_query){
if($image_size > 2000000){
 $message[] = 'image size is too large';
}else{
 move_uploaded_file($image_tmp_name, $image_folder);
 $message[] = 'Product added successfully!';
}
 }else{
$message[] = 'Product could not be added!';
}
}
}


if(isset($_GET['delete'])){
$delete_id = $_GET['delete'];
$delete_image_query = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('query failed');
$fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
unlink('uploaded_img/'.$fetch_delete_image['image']);
mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');
header('location:user_products.php');
}

if(isset($_POST['update_product'])){

$update_p_id = $_POST['update_p_id'];
$update_name = $_POST['update_name'];
$update_author = $_POST['update_author'];
$update_price = $_POST['update_price'];
$update_bookcondition = $_POST['update_bookcondition'];
$update_tradeoption = $_POST['update_tradeoption'];
$update_isbn = $_POST['update_isbn'];

mysqli_query($conn, "UPDATE `products` SET name = '$update_name',author = '$update_author', price = '$update_price', bookcondition = '$update_bookcondition', tradestatus = '$update_tradeoption', isbn = '$update_isbn' WHERE id = '$update_p_id'") or die('query failed');

$update_image = $_FILES['update_image']['name'];
$update_image_tmp_name = $_FILES['update_image']['tmp_name'];
$update_image_size = $_FILES['update_image']['size'];
$update_folder = 'uploaded_img/'.$update_image;
$update_old_image = $_POST['update_old_image'];

if(!empty($update_image)){
 if($update_image_size > 2000000){
$message[] = 'image file size is too large';
 }else{
mysqli_query($conn, "UPDATE `products` SET image = '$update_image' WHERE id = '$update_p_id'") or die('query failed');
move_uploaded_file($update_image_tmp_name, $update_folder);
unlink('uploaded_img/'.$update_old_image);
 }
}

header('location:user_products.php');
}


 
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>products</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!--  <link rel="stylesheet" href="css/admin_style.css">-->
  <link rel="stylesheet" href="css/admin-section/admin_style.css">
  <link rel="stylesheet" href="css/update_book_process.css">

  </head>
<body>
  
<?php include 'header.php'; ?>

<section class="add-products">
  <h1 class="title">shop products</h1>
<form action="" method="post" enctype="multipart/form-data">
  <h3>add product</h3>
  <input type="text" name="name" class="box" placeholder="enter product name" required>
  <input type="text" name="author" class="box" placeholder="enter book author" required>
  <input type="text" name="isbn" id="isbn" class="box" placeholder="enter ISBN (optional)"> 
  <input type="number" min="0" name="price" class="box" placeholder="enter product price" required>
  <!--<input type="text" name="author" class="box" placeholder="enter book author" required>-->
  <div class="addproductsoption">
    <select name="bookcondi" class="box">
        <option value="" selected disabled hidden>Choose Book Condition</option>
        <option value="Old">Old</option>
        <option value="New">New</option>
        <option value="Used">Used</option>
    </select>   
  </div>

  <div class="tradeoption">
    <select name="tradestatus" class="box">
        <option value="" selected disabled hidden>Is the book open for trading?</option>
        <option value="Yes">This book is also open for trading</option>
        <option value="No">This book is not open for trading</option>
    </select>   
  </div>

  <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>

  <input type="submit" value="add product" name="add_product" class="btn">
</form>
</section>

<section class="show-products">
  <div class="box-container">
    <?php
    $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE seller_id = '$user_id'") or die('query failed');
    if(mysqli_num_rows($select_products) > 0){
    while($fetch_products = mysqli_fetch_assoc($select_products)){
    ?>
      <div class="box">
      <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
      <div class="name"><?php echo $fetch_products['name']; ?></div>
      <div class="author">By: <?php echo $fetch_products['author']; ?></div>
      <div class="price">₱<?php echo $fetch_products['price']; ?>/-</div>
      <div class="author">Book Condition: <?php echo $fetch_products['bookcondition']; ?></div>
      <div style="display:flex; justify-content:center; " class="author">Seller:<p class="author"><span><?php echo $_SESSION['user_name']; ?></span></p></div>
      <a style="display: none;" href="user_products.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn">UPDATE</a>
      <!--<a href="user_products.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>-->
      
        <p>___________________________________</p>
        <span style="font-size:25px; color:black; font-weight:bold;">Update Book Details</span>
        
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="update_p_id" value="<?php echo $fetch_products['id']; ?>">  
            <input type="hidden" name="update_old_image" value="<?php echo $fetch_products['image']; ?>">
            <span class="book_desc">Book Title:</span>
            <input type="text" name="update_name" value="<?php echo $fetch_products['name']; ?>" class="box_ubd" required>
            <span class="book_desc">Book Author:</span>
            <input type="text" name="update_author" value="<?php echo $fetch_products['author']; ?>" class="box_ubd" required>
            <!--<label for="" class="box">Book Title:</label> --> 
            <!--<input type="text" name="update_name" value="<?php echo $fetch_products['name']; ?>" class="box_ubd" required>-->
            <span class="book_desc">Book Price:</span>
            <input type="number" name="update_price" value="<?php echo $fetch_products['price']; ?>" min="0" class="box_ubd" required>
            <span class="book_desc">ISBN:</span>
            <input type="text" name="update_isbn" value="<?php echo $fetch_products['isbn']; ?>" class="box_ubd" required>
            <span class="book_desc">Book Condition:</span>
              <select name="update_bookcondition" class="box_ubd">
                <option value="" selected="selected" hidden="hidden">Choose Here</option>
                <option value="Old">Old</option>
                <option value="New">New</option>
                <option value="Used">Used</option>
              </select>
              <span class="book_desc">Trading Option:</span>
              <select name="update_tradeoption" class="box_ubd">
                <option value="" selected="selected" hidden="hidden">Choose Here</option>
                <option value="Yes">This book is also open for trading</option>
                <option value="No">This book is not open for trading</option>
              </select>
           
            <span class="book_desc">Book Image:</span>
            <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box_ubd">
            <input type="submit" value="update" name="update_product" class="option-btn">
            <a href="user_products.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
        </form>
      </div>
    <?php
      } }else{echo '<p class="empty">No products added yet!</p>';}
    ?>
</div>
</section>

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>
</body>
</html>
