<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];
$email = $_SESSION['user_email'];



if(!isset($user_id)){
header('location:login.php');
}



require 'vendor/autoload.php';// Assuming PHPMailer installed via Composer
use PHPMailer\PHPMailer;

// Initialize $message as an array
$message = [];

if(isset($_POST['contact_seller'])){

    // Optional - Sanitize input to prevent malicious code
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $seller_id = mysqli_real_escape_string($conn, $_POST['seller_id']);
    $name = isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : ''; 
    $number = isset($_POST['number']) ? mysqli_real_escape_string($conn, $_POST['number']) : ''; 
    $tempMessage = isset($_POST['message']) ? mysqli_real_escape_string($conn, $_POST['message']) : '';

    $select_seller = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$seller_id'"); 
    if(mysqli_num_rows($select_seller) > 0){
        $fetch_seller = mysqli_fetch_assoc($select_seller);
        $seller_email = $fetch_seller['email'];

        $insert_message = mysqli_query($conn, "INSERT INTO `messages`(sender_id, receiver_id, message) VALUES('$user_id', '$seller_id', 'Contact request regarding product: $product_name. Email: $email ')") or die('query failed');

        // Mailtrap Integration 
        $mail = new PHPMailer\PHPMailer(true);
        echo "Mail object created."; // Temporary test 
        var_dump($message); // Temporary test

        try{
        // Mailtrap configuration
        $mail->SMTPDebug = 0; // Turn off debugging for production
        $mail->isSMTP();                                     
        $mail->Host = 'sandbox.smtp.mailtrap.io';                 
        $mail->SMTPAuth = true;                          
        $mail->Username = '496a802ecda08c';         
        $mail->Password = 'aebd5b52bf4176';            
        $mail->SMTPSecure = 'tls';                            
        $mail->Port = 2525;
        
        echo "Email: " . $email; 
        echo "Name: " . $name; 
        $mail->setFrom($email, $name); 


        $mail->setFrom($email, $name); 
        $mail->addAddress($seller_email); 
        $mail->isHTML(true);                                 
        $mail->Subject = 'New contact request regarding product: ' . $product_name;  
        $mail->Body = "Contact request regarding product: $product_name. Email: $email"; 

        $mail->send();
        $message[] = 'Message sent successfully!';
        } catch (Exception $e) {
        $message[] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $message[] = 'Seller not found!';
    }
}

// Display messages (Place this where you want them displayed on the page)
if(!empty($message)){ 
    foreach($message as $singleMessage){
        echo "<div class='message-box'>". $singleMessage ."</div>"; 
    }
} 
?>
<!DOCTYPE html>


<!DOCTYPE html>
<html lang="en">
<head>
   </head>
<body>
  
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

    <?php include 'header.php'; ?> 

    <section class="chat-directory">
<div class="wrapper">
    <div class="divA"><h1 class="title">Proceed to your Chat Section</h1></div>
    <div class="divB"><a href="messages.php"class="btn-messenging" id="special-color">Messenging</a></div>
</div>

</section>


    <?php include 'footer.php'; ?> 

    <!-- custom js file link  -->
    <script src="js/script.js"></script>
    </body>
</html>
