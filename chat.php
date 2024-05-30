<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_GET['user_id'])) {
    $user_two_id = $_GET['user_id'];
}

// Fetch the name and profile image of the user you are chatting with   
$select_user_two = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$user_two_id'") or die('query failed');
if (mysqli_num_rows($select_user_two) > 0) {
    $fetch_user_two = mysqli_fetch_assoc($select_user_two);

    // Profile Image Check
    $profile_image = (file_exists("uploaded_img/" . $fetch_user_two['image']) &&  $fetch_user_two['image'] != "") 
        ? "uploaded_img/" . $fetch_user_two['image']
        : "images/default_profile.png"; 
} else {
    // Handle the case where the user is not found (e.g., redirect or display error)
    header('location:messages.php'); // You might want to redirect to messages
}

// Handle new messages
if (isset($_POST['send'])) {
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    if ($message != "") { // Ensure the message isn't empty 
        mysqli_query($conn, "INSERT INTO `messages`(sender_id, receiver_id, message, timestamp) VALUES('$user_id', '$user_two_id', '$message', NOW())") or die('query failed');
    } 

    // After sending the message, fetch all the messages again to update the UI
    header('location:chat.php?user_id='.$user_two_id); // Refresh after sending
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="css/admin_style.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php include 'header.php'; ?>

    <section class="chat" style="margin-top:100px">
        <h1 class="title-chat">Chat Section</h1>

        <div class="chat-container"> 
            <div class="chat-header">
                <h3>Chatting with: <span><?php echo $fetch_user_two['name'] ?></span> 
                </h3>
            </div>
            <div class="chat-box">
                
               </div>

            <form action="" method="post" class="send-message" onsubmit="sendMessage(event)">
                <input type="text" name="message" class="textbox" placeholder="enter message">
                <input type="submit" name="send" value="send" class="btn">
            </form>
        </div> 
    </section>

    <?php include 'footer.php'; ?>
    <script src="js/script.js"></script>
    <script src="js/admin_script.js"></script>

    <script>
        var lastTimestamp = 0; 
        var current_user_id = <?php echo $user_id; ?>;
        var user_two_id = <?php echo $user_two_id; ?>;
        function fetchNewMessages() {
            // Make an AJAX request to fetch new messages
            fetch(`get_new_messages.php?user_id=${user_two_id}&last_timestamp=${lastTimestamp}`)
                .then(response => response.json())
                .then(data => {
                    const chatBox = document.querySelector('.chat-box');
                    if (data.length > 0) { //check if the data has values
                        data.forEach(message => {
                        
                            // Fetch sender's profile image
                            fetch('fetch_user_image.php?user_id=' + message.sender_id)
                                .then(response => response.json())
                                .then(data => {
                                    const profileImage = data.image ? `uploaded_img/${data.image}` : 'images/default_profile.png';
                                    // Check if the current user is the sender 
                                    if(message.sender_id == current_user_id) {
                                        chatBox.innerHTML += `<div class="msg you"><p>${message.message}</p></div>`; 
                                    } else {
                                        chatBox.innerHTML += `<div class="msg other"><img src="${profileImage}" alt="Profile Image" class="profile-pic-small"><p>${message.message}</p></div>`;
                                    }
                                });

                            // Update lastTimestamp
                            lastTimestamp = message.timestamp;
                        });

                        // Auto scroll to the bottom after adding new messages
                        chatBox.scrollTop = chatBox.scrollHeight;
                    }
                })
                .catch(error => console.error('Error fetching new messages:', error));
        }
        
        // Update every second
        setInterval(fetchNewMessages, 1000); // 1000ms = 1 second
        // Initial call
        fetchNewMessages();

        function sendMessage(event) {
            event.preventDefault();
            const messageInput = document.querySelector('.send-message .box');
            const message = messageInput.value.trim();

            if (message != "") { 
            // Send the message to the server (using AJAX)
            fetch('chat.php?user_id=' + user_two_id, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `send=&message=${message}`
            })
            .then(() => {
                // Clear the input field
                messageInput.value = '';

                // Fetch new messages immediately
                fetchNewMessages();
            })
            .catch(error => console.error('Error sending message:', error));
            }
        }

    </script>
</body>
</html>
