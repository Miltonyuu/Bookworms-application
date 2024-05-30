<?php
include 'config.php';
session_start();

if (isset($_GET['token'])) {
    $token = mysqli_real_escape_string($conn, $_GET['token']);

    // Fetch user by reset token
    $select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE reset_token = '$token' AND reset_expiration > NOW()") or die('query failed');

    if (mysqli_num_rows($select_user) > 0) {
        $user = mysqli_fetch_assoc($select_user);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin_style.css">
    <link rel="stylesheet" href="css/style.css">

    <script>
        function closeModal() {
            document.getElementById("password-updated-modal").style.display = "none";
            window.location.href = 'login.php'; // Redirect after closing the modal
        }
    </script>
</head>

<body class="reset_password">
    

    <div id="password-updated-modal" class="modal" style="display: none;"> 
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2>Password Updated</h2>
            <p>Your password has been successfully updated!</p>
        </div>
    </div>

    <div class="resetform-container">
        <form action="" method="post">
            <h3>Reset Password</h3>
            <?php
            if (isset($message)) {
                foreach ($message as $message) {
                    echo '<div class="message"><span>' . $message . '</span> <i class="fas fa-times" onclick="this.parentElement.remove();"></i></div>';
                }
            }
            ?>
            <input type="password" name="new_pass" placeholder="Enter new password" class="box" required>
            <input type="password" name="confirm_pass" placeholder="Confirm new password" class="box" required>
            <input type="submit" value="Update Password" name="update_pass" class="btn">
        </form>
    </div>

   

    <?php
        if (isset($_POST['update_pass'])) {
            $new_pass = mysqli_real_escape_string($conn, md5($_POST['new_pass']));
            $confirm_pass = mysqli_real_escape_string($conn, md5($_POST['confirm_pass']));

            if ($new_pass != $confirm_pass) {
                $message[] = 'Confirm password does not match!';
            } else {
                mysqli_query($conn, "UPDATE `users` SET password = '$confirm_pass', reset_token = NULL, reset_expiration = NULL WHERE id = '{$user['id']}'") or die('query failed');
                
                // Display success message in a modal
                echo '
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        document.getElementById("password-updated-modal").style.display = "block";
                        setTimeout(function() {
                            closeModal(); // Call closeModal() after a delay to redirect
                        }, 2000); // Redirect after 2 seconds (2000 milliseconds)
                    });
                </script>';
            }
        }
    } else {
        $message[] = 'Invalid or expired token!';
        header('location:login.php');
        exit();
    }
} else {
    header('location:login.php');
    exit();
}
?>
</body>
</html>
