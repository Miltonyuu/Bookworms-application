<?php
//require_once 'policies.php';
include 'config.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $gender = $_POST['gender'];
   $birthday = $_POST['birthday'];

   $select_users = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if ($pass != $cpass) {
      $message[] = 'Confirm password does not match!';
   } else {
      $select_users = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'") or die('Query failed');

      if (mysqli_num_rows($select_users) > 0) {
         $message[] = '<div class="register-message">User already exists</div>';
     }
      else {
         mysqli_query($conn, "INSERT INTO users (name, email, password, gender, birthdate) VALUES ('$name', '$email', '$pass', '$gender', '$birthday')") or die('Query failed');
         $message[] = 'Registered successfully!';
         header('Location: login.php');
         exit(); // Always exit after a header redirect
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

   <style>
      .close:hover,
      .close:focus {
         color: #000;
         text-decoration: none;
         cursor: pointer;
      }
      
      /* Animation for modal */
      @keyframes fadeIn {
         from { opacity: 0; }
         to { opacity: 1; }
      }
      
      .modal {
         display: none; /* Hidden by default */
         position: fixed; /* Stay in place */
         
         padding-top: 140px; /* Location of the box */
         left: 0;
         top: 10;
         width: 100%; /* Full width */
         height: 100%; /* Full height */
         overflow: auto; /* Enable scroll if needed */
         background-color: rgb(0,0,0); /* Fallback color */
         background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
         animation: fadeIn 0.5s; /* Apply the fade-in animation */
      }

      .modal-content {
         background-color: #fefefe;
         margin: auto;
         padding: 30px;
         border: 1px solid #888;
         width: 80%;
         border-radius:20px;
         font-size: 12px; 
         text-align: justify;
      }

      .close {
         color: #aaaaaa;
         float: right;
         font-size: 28px;
         font-weight: bold;
      }

      .close:hover,
      .close:focus {
         color: #000;
         text-decoration: none;
         cursor: pointer;
      }

      .error {
         color: red;
         display: none;
         font-size: 15px;
      }

   </style>
</head>
<body class="register">
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

<div class="regform-container">
   
   <form action="" method="post">
      <h1>Register now</h1>
      <p required class="name">Full Name</p>
      <input type="text" name="name" placeholder="Enter your name" required class="box">
      <p required class="email">Email Address</p>
      <input type="email" name="email" placeholder="Enter your email" required class="box">
      <p required class="password">Password</p>
      <input type="password" name="password" id="password" placeholder="Enter your password" required class="box">
      <input type="password" name="cpassword" id="cpassword" placeholder="Confirm your password" required class="box">
      <span id="error-message" class="error">Passwords do not match</span>
      <p required class="gender">Gender</p>
      <select name="gender" class="box">
         <option value="" selected disabled>Select Gender</option>
         <option value="male">Male</option>
         <option value="female">Female</option>
    
      <p required class="dateofbirth">Date of Birth</p>
      <input type="date" name="birthday" required class="box">
      <div class="checkbox-container">
         <input type="checkbox" id="agree-terms" name="agree" required>
         <label for="agree-terms">I agree to the Terms of Service and Privacy Policy</label>
      </div>
      <input type="submit" name="submit" value="register now" class="btn" id="submit-btn" disabled>
      <br><br>
      <h4>Already have an account? <a href="login.php">Login now</a></h4>
   </form>
</div>

<div id="policies-container" class="modal">
   <div class="modal-content">
      <span class="close">&times;</span>
      <!-- Privacy Policy Content -->
      <h2 style="text-align: center;">Privacy Policy</h2>
      <br>
      <h3 style="text-align: center;">Information We Collect</h3>
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
      <h3 style="text-align:center;"><b>Use of Information</b></h3>
      <br>
      <p>
         <b>a.</b> We use collected information to manage user accounts, including registration, authentication, and account recovery. <br>
         <b>b.</b> We use email addresses to send important notifications and updates related to Bookworms Connect. Users can opt-out of non-essential communications. <br>
         <b>c.</b> Contact and address information may be used to facilitate book swaps between users. <br>
         <b>d.</b> We may analyze user data to improve our services, enhance user experience, and develop new features.
      </p>
      <br>
      <h3 style="text-align:center;"><b>Sharing of Information</b></h3>
      <br>
      <p>
         <b>a.</b> We may share personal information with third-party service providers to perform functions on our behalf, such as hosting, analytics, and customer support. <br>
         <b>b.</b> We may disclose personal information when required by law or to protect the rights, property, or safety of Bookworms Connect, its users, or others.
      </p>
      <br>
      <h3 style="text-align:center;"><b>User Rights</b></h3>
      <br>
      <p>
         <b>a.</b> Users can access and update their personal information through their account settings. <br>
         <b>b.</b> Users can request the deletion of their account and associated personal information by contacting us at bookwormsconnectPH.com.
      </p>
      <br>
      <h3 style="text-align:center;"><b>Policy Updates</b></h3>
      <br>
      <p>
      
         <b>a.</b> We may update this Privacy Policy from time to time. Users will be notified of any material changes via email or through a notice on our website.
      </p>
      <br>
      <h2 style="text-align: center;">Terms of Service</h2>
      <br>
      <p><b>Eligibility:</b> You must be at least 18 years old to use Bookworms Connect. By registering for an account, you confirm that you meet this requirement.</p>
      <p><b>User Conduct:</b> You agree to use Bookworms Connect in compliance with all applicable laws and regulations. You will not engage in any activity that violates the rights of others or harms the integrity of the platform.</p>
      <p><b>Account Security:</b> You are responsible for maintaining the security of your account credentials. You will notify us immediately of any unauthorized access or use of your account.</p>
      <p><b>Intellectual Property:</b> You retain ownership of the content you upload to Bookworms Connect. By submitting content, you grant us a non-exclusive, royalty-free license to use, modify, and distribute it for the purpose of operating and improving our services.</p>
      <p><b>Limitation of Liability:</b> Bookworms Connect is provided "as is" without warranties of any kind. We are not liable for any damages arising from your use of the platform. Additionally, Bookworms Connect is not liable for any failed book swaps or trades between users. Users are responsible for any agreements or transactions they make with other users on the platform.</p>
   </div>
</div>

<script>

document.getElementById("password").addEventListener("input", validatePasswords);
document.getElementById("cpassword").addEventListener("input", validatePasswords);
document.getElementById("agree-terms").addEventListener("change", toggleSubmitButton);

function validatePasswords() {
  var password = document.getElementById("password").value;
  var confirmPassword = document.getElementById("cpassword").value;
  var errorMessage = document.getElementById("error-message");
  var submitButton = document.getElementById("submit-btn"); // Get submit button reference

  if (password && confirmPassword && password !== confirmPassword) {
    errorMessage.style.display = "block";
    submitButton.disabled = true;
    submitButton.classList.add("error"); // Add error class for visual cue
  } else {
    errorMessage.style.display = "none";
    submitButton.disabled = false;
    submitButton.classList.remove("error"); // Remove error class if valid
    if (document.getElementById("agree-terms").checked && password && confirmPassword) {
      submitButton.disabled = false;
    }
  }
}

function toggleSubmitButton() {
  var password = document.getElementById("password").value;
  var confirmPassword = document.getElementById("cpassword").value;
  var submitButton = document.getElementById("submit-btn"); // Get submit button reference

  if (this.checked && password && confirmPassword && password === confirmPassword) {
    submitButton.disabled = false;
    submitButton.classList.remove("error"); // Remove error class if valid
  } else {
    submitButton.disabled = true;
    submitButton.classList.add("error"); // Add error class for visual cue
  }
}

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

    const modal = document.getElementById("policies-container");
    const span = document.getElementsByClassName("close")[0];

  // When the user clicks on <span> (x), close the modal
   span.onclick = function() {
    modal.style.display = "none";
  }

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
</script>
</body>
</html>
