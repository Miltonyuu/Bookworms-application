<?php
include 'config.php';
session_start();

use PayPal\Api\Payment;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

require 'vendor/autoload.php';

// PayPal API Configuration (Replace with your credentials)
$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'AaRTdFw24EcdsVLTQruOZimbbgmRuuUjmVXF3jByjUdLWaOa1iNh7qY-2TRdT2OxtfYeOokzSui3ZuUq',     // Replace with your actual Client ID
        'EM8wKjTZ-SFmVHWvfB8lr0kugKMqCJM8XXDcLujB_PCbCtdUlGnifElOwM_liB2uvGI8z0APXmHQGFqG'  // Replace with your actual Client Secret
    )
);
$apiContext->setConfig(
    array(
        'mode' => 'sandbox' 
    )
);

$messages = []; 

if (isset($_POST['submit_verification'])) {
    // Handle form data (valid_id upload)
   
    // Valid ID Upload Handling 
    $target_dir = "uploaded_ids/";  
    $original_filename = basename($_FILES["valid_id"]["name"]);
    $hashed_filename = hash('sha256', $original_filename . time());  
    $target_file = $target_dir . $hashed_filename;  
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["valid_id"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $message[] = "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists (optional)
    if (file_exists($target_file)) {
        $message[] = "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size (optional)
    if ($_FILES["valid_id"]["size"] > 50000000) { // 50000KB limit
        $message[] = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    

    if ($uploadOk == 0) {
        $message[] = "Sorry, your file was not uploaded.";
    } else { // if everything is ok, try to upload file
        if (move_uploaded_file($_FILES["valid_id"]["tmp_name"], $target_file)) {
            // File uploaded successfully

            // Insert verification request (store the hashed filename)
            $insert_query = "INSERT INTO verification_requests (user_id, valid_id, status) VALUES ('$user_id', '$hashed_filename', 'pending')";
            if (mysqli_query($conn, $insert_query)) {
                $message[] = 'Verification request submitted successfully! Please proceed with the payment.';

                // Create a new payment
                $payer = new Payer();
                $payer->setPaymentMethod("paypal");

                $amount = new Amount();
                $amount->setCurrency("PHP")
                    ->setTotal(200.00);  // Verification fee in PHP

                $transaction = new Transaction();
                $transaction->setAmount($amount)
                    ->setDescription("User Verification Fee");

                $redirectUrls = new RedirectUrls();
                $redirectUrls->setReturnUrl("http://localhost/Bookworms-application/verify_user.php?success=true")  
                    ->setCancelUrl("http://localhost/Bookworms-application/verify_user.php?cancel=true");  

                $payment = new Payment();
                $payment->setIntent("sale")
                    ->setPayer($payer)
                    ->setRedirectUrls($redirectUrls) // Corrected method name
                    ->setTransactions(array($transaction));
    
                try {
                    $payment->create($apiContext);

                    // Redirect the user to PayPal for payment approval (in a new window)
                    echo "<script>window.open('{$payment->getApprovalLink()}', '_blank');</script>";
                    exit;
                } catch (PayPal\Exception\PayPalConnectionException $ex) {
                    $message[] = "Error connecting to PayPal: " . $ex->getMessage();
                }
            } else {
                $message[] = 'Failed to submit verification request. Please try again later.';
            }
        } else {
            $message[] = "Sorry, there was an error uploading your file.";
        }
    }
}

// Handle the return from PayPal
if (isset($_GET['success']) && $_GET['success'] == 'true') {
    // Payment was successful, mark the user as verified
    mysqli_query($conn, "UPDATE `users` SET verified = 1 WHERE id = '$user_id'") or die('query failed');
    $message[] = 'Payment successful! Your account is now verified.';
} elseif (isset($_GET['cancel']) && $_GET['cancel'] == 'true') {
    $message[] = 'Payment cancelled. Your verification request will not be processed.';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <?php include 'header.php'; ?>

    <section class="verify-user-form">

        <h1 class="title">Verify Your Account</h1>
           <!-- font awesome cdn link  -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

        <!-- custom css file link  -->
        <link rel="stylesheet" href="css/style.css">

        <?php
        // Display messages
        if (!empty($messages)) {
            foreach ($messages as $singleMessage) {
                echo '<div class="message"><span>' . $singleMessage . '</span> <i class="fas fa-times" onclick="this.parentElement.remove();"></i></div>';
            }
        }
        ?>
        
        <div class="verify_box">

            <form action="" method="post" enctype="multipart/form-data">
                <h3>User Verification</h3>
                <p>Submit your Valid Documents for Verification below</p>
                <input type="file" name="valid_id" accept="image/*" class="box_choose_file" required />
                <input type="submit" name="submit_verification" value="Submit for Verification" class="btn" style="display:block;">
            </form>

        </div>

        <div class="modal-content">
        <h3 style="text-align: center;">Potential Benefits of Being a Verified User</h3>
            <br>
            <p>
                <b>a. Verified Badge:</b> You'll receive a verified badge that signifies you've completed the identity verification process. <br>
                <b>b. Increased Trust:</b>  This badge makes your actions and requests appear more credible, leading users to be more likely to trust your listings and feel comfortable trading or buying a book from you. <br>
                <b>c. Serious Seller Status:</b> Verification increases the chance of other users taking your listings seriously and considering buying or trading with you. It demonstrates you're a reputable seller or dealer. <br>
                <b>d. Stand Out from the Crowd:</b> Verified users are easily distinguished from unverified sellers/traders, potentially attracting more buyers. <br>
            </p>
            <br>
            <h3 style="text-align: center;">Steps to Get Verified</h3>
            <br>
            <p>
                <b>a. Submit Valid Documentation:</b>Provide one of your valid documents, such as a government ID, company ID, or NBI clearance. <br>
                <b>b. Verification Fee:</b> After submitting your documents, you'll be directed to PayPal to pay a verification fee of PHP 100. <br>
                <b>c. Verification Process:</b> Once your payment is received, the admin will verify your account. This process may take some time. <br>
                <b>d. Verification Confirmation: </b> The admin will confirm your account verification. If there's an issue with your documents or the process, the admin will contact you, and your payment will be refunded. <br>
                <b>e. Verified Badge: </b> Upon successful account verification, you'll receive a verified badge on the platform, indicating your verified status. <br>

            </p>
        </div>

    </section>
    <?php include 'footer.php'; ?>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>
</body>
</html>

