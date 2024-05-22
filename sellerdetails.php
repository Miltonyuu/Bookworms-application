<?php
include 'config.php';
session_start();

$email = $_SESSION['user_email'];
$user_id = $_SESSION['user_id'];

// Check Verification Status
$select_verification = mysqli_query($conn, "SELECT * FROM `verification_requests` WHERE user_id = '$user_id' AND status = 'approved'");
$is_verified = mysqli_num_rows($select_verification) > 0; // True if verified

if (!isset($user_id)) {
    header('location:login.php');
    exit;
}

if (isset($_POST['add_to_cart'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if (mysqli_num_rows($check_cart_numbers) > 0) {
        $message[] = 'already added to cart!';
    } else {
        mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
        $message[] = 'product added to cart!';
    }
}

// Fetch products
$fetch_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dashboard">
        <h1>Dashboard</h1>
        <div class="products">
            <?php while ($product = mysqli_fetch_assoc($fetch_products)): ?>
                <div class="product">
                    <h2><?php echo $product['name']; ?></h2>
                    <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                    <p>Price: <?php echo $product['price']; ?></p>
                    <button class="contact-seller-btn btn" 
                            data-product-name="<?php echo $product['name']; ?>" 
                            data-seller-id="<?php echo $product['seller_id']; ?>">View Seller's Details</button>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Seller details modal -->
    <div id="sellerDetailsModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="sellerDetails"></div>
        </div>
    </div>

    <script>
        // JavaScript to handle button click and fetch seller details
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('sellerDetailsModal');
            const modalContent = document.getElementById('sellerDetails');
            const closeBtn = document.querySelector('.close');

            document.querySelectorAll('.contact-seller-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const sellerId = this.getAttribute('data-seller-id');

                    // Fetch seller details using AJAX
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'fetch_seller_details.php', true);
                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    xhr.onload = function () {
                        if (this.status === 200) {
                            modalContent.innerHTML = this.responseText;
                            modal.style.display = 'block';
                        }
                    };
                    xhr.send('seller_id=' + sellerId);
                });
            });

            // Close modal
            closeBtn.addEventListener('click', function () {
                modal.style.display = 'none';
            });

            // Close modal when clicking outside of it
            window.addEventListener('click', function (event) {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>