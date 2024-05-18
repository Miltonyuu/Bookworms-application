<?php
require_once 'policies.php';
include 'config.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $gender = $_POST['gender'];
   $user_type = $_POST['user_type'];
   $birthday = $_POST['birthday'];

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){
      $message[] = 'user already exist!';
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }else{
         mysqli_query($conn, "INSERT INTO `users`(name, email, password, gender, birthdate, user_type) VALUES('$name', '$email', '$cpass', '$gender', '$birthday', '$user_type')") or die('query failed');
         $message[] = 'registered successfully!';
         header('location:login.php');
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
   <title>register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>



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
   
<div class="form-container">

   <form action="" method="post">
      <h3>Register now</h3>
      <p required class="name">Full Name</p>
      <input type="text" name="name" placeholder="enter your name" required class="box">
      <p required class="email">Email Address</p>
      <input type="email" name="email" placeholder="enter your email" required class="box">
      <p required class="password">Password</p>
      <input type="password" name="password" placeholder="enter your password" required class="box">
      <input type="password" name="cpassword" placeholder="confirm your password" required class="box">
      <p required class="gender">Gender</p>
      <select name="gender" class="box">
         <option value="" selected disabled>Select Gender</option>
         <option value="male">Male</option>
         <option value="female">Female</option>
      </select>
      <p required class="type">Role Type</p>
      <select name="user_type" class="box">
         <option value="" selected disabled>Select Type</option>
         <option value="user">User</option>
         <option value="admin">Admin</option>
      </select>
      <p required class="dateofbirth">Date of Birth</p>
      <input type="date" name="birthday" required class="box">
      <div class="checkbox-container"> <input type="checkbox" id="agree-terms" name="agree" required>
    <label for="agree-terms">I agree to the Terms of Service and Privacy Policy</label>
      
         </div>
         <input type="submit" name="submit" value="register now" class="btn">

      

         <p>Already have an account? <a href="login.php">Login now</a></p>
      </form>

   </div>


   <div id="policies-container" style="display: none; " >

   <h2 style="text-align: center;">Privacy Policy</h2>
<br>
<h3 >Information We Collect</h3>
<br>

<p>
  <b>a. Usernames:</b> We collect usernames chosen by users during registration to identify them on the platform. <br>
  <b>b. Email Addresses:</b> We collect email addresses to communicate important updates, account information, and notifications related to Bookworms Connect. Users can opt-out of non-essential communications. <br>
  <b>c. Contacts and Addresses:</b> Users may choose to provide their contacts and addresses for shipping purposes related to book swaps facilitated through the platform. <br>
  <b>d. Gallery Access:</b> If users choose to upload pictures to the platform, we may require access to their device's gallery. <br>
  <b>e. Messaging:</b> We collect information exchanged through the messaging feature on our website to facilitate communication between users. <br>
  <b>f. IP Address and Device Information:</b> We may collect IP addresses and device information for security and analytical purposes.
</p>
<br>
<p style="text-align:center;"><b>Use of Information</b></p>

<p>
<b>a.</b> We use collected information to manage user accounts, including registration, authentication, and account recovery. <br>
<b>b.</b> We use email addresses to send important notifications and updates related to Bookworms Connect. Users can opt-out of non-essential communications. <br>
<b>c.</b> Contact and address information may be used to facilitate book swaps between users. <br>
<b>d.</b> We may analyze user data to improve our services, enhance user experience, and develop new features.
</p>
<br>
<p style="text-align:center;"><b>Sharing of Information</b></p>
<br>
<p>
<b>a.</b> We may share personal information with third-party service providers to perform functions on our behalf, such as hosting, analytics, and customer support. <br>
<b>b.</b> We may disclose personal information when required by law or to protect the rights, property, or safety of Bookworms Connect, its users, or others.
</p>
<br>
<p style="text-align:center;"><b>User Rights</b></p>
<br>
<p>
<b>a.</b> Users can access and update their personal information through their account settings. <br>
<b>b.</b> Users can request the deletion of their account and associated personal information by contacting us at bookwormsconnectPH.com.
</p>

<p style="text-align:center;"><b>Policy Updates</b></p>

<p>
<b>a.</b> We may update this Privacy Policy from time to time. Users will be notified of any material changes via email or through a notice on our website.
</p>

<h2 style="text-align: center;">Terms of Service</h2>

<p><b>Eligibility:</b> You must be at least 18 years old to use Bookworms Connect. By registering for an account, you confirm that you meet this requirement.</p>

<p><b>User Conduct:</b> You agree to use Bookworms Connect in compliance with all applicable laws and regulations. You will not engage in any activity that violates the rights of others or harms the integrity of the platform.</p>

<p><b>Account Security:</b> You are responsible for maintaining the security of your account credentials. You will notify us immediately of any unauthorized access or use of your account.</p>

<p><b>Intellectual Property:</b> You retain ownership of the content you upload to Bookworms Connect. By submitting content, you grant us a non-exclusive, royalty-free license to use, modify, and distribute it for the purpose of operating and improving our services.</p>

<p><b>Limitation of Liability</b> Bookworms Connect is provided "as is" without warranties of any kind. We are not liable for any damages arising from your use of the platform. Additionally, Bookworms Connect is not liable for any failed book swaps or trades between users. Users are responsible for any agreements or transactions they make with other users on the platform.</p>


</div>

   <script>
  // Get references to elements
  const agreeCheckbox = document.getElementById('agree-terms');
  const submitButton = document.querySelector('.btn');
  const policiesContainer = document.getElementById('policies-container');

  // Initially show the policies container (optional, adjust as needed)
  policiesContainer.style.display = 'block'; // Change to 'none' to hide initially

  // Toggle visibility based on checkbox state
  agreeCheckbox.addEventListener('change', function() {
    policiesContainer.style.display = this.checked ? 'block' : 'none';
  });

  // Disable submit button by default
  submitButton.disabled = true;

  // Enable submit button only when checkbox is checked
  agreeCheckbox.addEventListener('change', function() {
    submitButton.disabled = !this.checked;
  });

</script>


</body>
</html>