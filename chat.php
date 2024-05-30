<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location:login.php');
}

if (isset($_GET['user_id'])) {
    $user_two_id = $_GET['user_id'];
}

$initial_load = !isset($_POST['send']);

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

    // After sending, clear the message input field (no redirection)
    echo '<script>document.querySelector(".send-message .box").value = "";</script>';
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
    

    <section class="chat">
    <h1 class="title-chat">Chat Section</h1>
            <div class="chat-header">
                <h3>Chatting with: <span><?php echo $fetch_user_two['name'] ?></span> 
                </h3>
            </div>
            <div class="chat-box">
                <?php
                if($initial_load) {
                    $select_messages = mysqli_query($conn, "SELECT * FROM `messages` WHERE (sender_id = '$user_id' AND receiver_id = '$user_two_id') OR (sender_id = '$user_two_id' AND receiver_id = '$user_id') ORDER BY timestamp") or die('query failed');
       
                    if(mysqli_num_rows($select_messages) > 0){
                        while($fetch_messages = mysqli_fetch_assoc($select_messages)){
                            $message_sender_id = $fetch_messages['sender_id'];

                            // Get sender's profile image
                            $sender_profile_query = mysqli_query($conn, "SELECT image FROM `users` WHERE id = '$message_sender_id'") or die('query failed');
                            $fetch_sender_profile = mysqli_fetch_assoc($sender_profile_query);
                            $sender_profile_image = (!empty($fetch_sender_profile['image'])) ? $fetch_sender_profile['image'] : 'images/default_profile.png';
                            
                            if($fetch_messages['sender_id'] == $user_id){ 
                                echo '<div class="msg you"><p>'.$fetch_messages['message'].'</p></div>';
                            }else{ 
                                echo '<div class="msg other"><img src="uploaded_img/' . $sender_profile_image . '" alt="Profile Image" class="profile-pic-small"><p>'.$fetch_messages['message'].'</p></div>';
                            }      
                        } 
                    } else {
                        echo "<p class='empty'>Start the conversation!</p>";
                    }
                }

                ?>
            </div>

            <form action="" method="post" class="send-message" onsubmit="sendMessage(event)">
                <input type="text" name="message" class="box" placeholder="enter message">
                <input type="submit" name="send" value="send" class="btn">
            </form>
        </div> 
    </section>
    <?php include 'footer.php'; ?>
    <script src="js/script.js"></script>
    <script src="js/admin_script.js"></script>
    <script>
        var lastTimestamp = new Date().getTime(); 
        var current_user_id = <?php echo $user_id; ?>;
        var user_two_id = <?php echo $user_two_id; ?>;
        // Array to store displayed message IDs
        var displayedMessageIds = [];

        function fetchNewMessages() {
            fetch(`get_new_messages.php?user_id=${user_two_id}&last_timestamp=${lastTimestamp}`)
                .then(response => response.json())
                .then(newMessages => {
                    const chatBox = document.querySelector('.chat-box');
                    if (newMessages.length > 0) { 
                        newMessages.forEach(message => {
                            
                            // Check if the message is new
                            if (!displayedMessageIds.includes(message.id)) { // Check if message is new
                                displayedMessageIds.push(message.id);

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
                                lastTimestamp = (new Date(message.timestamp)).getTime();
                            }
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
