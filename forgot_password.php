<?php
include 'config.php';
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';  // Make sure you've installed PHPMailer via Composer

if (isset($_POST['submit_email'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

    if (mysqli_num_rows($select_user) > 0) {
        $user = mysqli_fetch_assoc($select_user);
        $token = bin2hex(random_bytes(16)); // Generate a random reset token

        // Update the user's record with the token
        mysqli_query($conn, "UPDATE `users` SET reset_token = '$token', reset_expiration = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE id = '{$user['id']}'") or die('query failed');

        // Send password reset email (using PHPMailer)
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->SMTPDebug = 0; // Turn off detailed debugging for production
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP host
            $mail->SMTPAuth = true;
            $mail->Username = 'miltonbautista60@gmail.com';   // Replace with your SMTP username
            $mail->Password = 'assn jebv uojl full';            // Replace with your SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         
            $mail->Port = 465;

            $mail->setFrom('miltonbautista60@gmail.com', 'Bookworms Connect'); // Replace with actual "From" email and name
            $mail->addAddress($email, $user['name']);

            $mail->isHTML(true);                                  
            $mail->Subject = 'Bookworms Connect - Reset Your Password';

            // Create a reset link
            $resetLink = "http://localhost/Bookworms-application/reset_password.php?token=$token"; // Update the URL to match your project

            $mail->Body    = "Hi {$user['name']},<br><br>You requested to reset your password for your Bookworms Connect account. Please click the following link to reset your password: <a href='$resetLink'>Reset Password</a>";

            $mail->send();
            $message[] = 'Password reset link has been sent to your email!';
        } catch (Exception $e) {
            $message[] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $message[] = 'No account found with that email address.';
    }
}



?>
<!DOCTYPE html>
<html lang="en">

 <!-- Font Awesome CDN link -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- Custom CSS file link -->
<link rel="stylesheet" href="css/style.css">

<head>
  
</head>

<body class="forgot_password">

    <div class="forgotform-container">
        <form action="" method="post">
            
            <?php
                if(isset($message)){
                foreach($message as $message){
                    echo '
                        <div class="message">
                            <span>'.$message.'</span>
                            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                        </div>
                    ';
                }
            }
            ?>

            <h3>Forgot Password</h3>
            <br>
            <input type="email" name="email" placeholder="Enter your email" required class="box">
            <input type="submit" name="submit_email" value="Send Reset Link" class="btn">
            <br><br>
            <p>Already have an account? <a href="login.php">Login now</a></p>
            <p>Don't have an account? <a href="register.php">Register now</a></p>
        </form>
    </div>

</body>
</html>
