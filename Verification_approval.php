<?php
include 'config.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
header('location:login.php');
}

if(isset($_POST['update_request'])){
  $request_id = $_POST['request_id'];
  $update_verification = $_POST['update_verification'];
  mysqli_query($conn, "UPDATE `verification_requests` SET status = '$update_verification' WHERE id = '$request_id'") or die('query failed');
  $message[] = 'verification status has been updated!';
}


?>
<!DOCTYPE html>
<html lang="en">
    <head>

        <!-- font awesome cdn link  -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <!-- custom admin css file link  -->
        <link rel="stylesheet" href="css/admin-section/admin_style.css">
    </head>
<body>
    <?php include 'admin_header.php'; ?>

    <section class="verification-requests">
        <h1 class="title">Verification Requests</h1>
        <div class="box-container">
            <?php
            $select_requests = mysqli_query($conn, "SELECT * FROM `verification_requests` WHERE status = 'pending'") or die('query failed');
            if(mysqli_num_rows($select_requests) > 0){
                while($fetch_requests = mysqli_fetch_assoc($select_requests)){
            ?>
            <div class="verify-box">
                <p> user id : <span><?php echo $fetch_requests['user_id']; ?></span> </p>
                <img src="uploaded_ids/<?php echo $fetch_requests['valid_id']; ?>" alt="">
                <form action="" method="POST">
                    <input type="hidden" name="request_id" value="<?php echo $fetch_requests['id']; ?>">
                    <select name="update_verification" class="verification-box">
                        <option value="" selected disabled>Pending</option>
                        <option value="approved">Approve</option>
                        <option value="rejected">Reject</option>
                    </select>
                    <input type="submit" value="Update" name="update_request" class="btn">
                </form>
            </div>
            <?php
                }
            }else{
                echo '<div><p class="empty" style="justify-content:center">no verification requests yet!</p></div>';
            }
            ?>
        </div>
    </section>

    <!-- custom admin js file link  -->
    <script src="js/admin_script.js"></script>

</body>
</html>
