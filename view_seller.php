<?php include 'header.php'; ?> 
<?php

function viewSellerDetails($sellerId) {
  // Database connection details (replace with your actual credentials)
  $host = 'localhost';
  $username = 'root';
  $password = '';
  $database = 'shop_db';

  // Establish database connection
  $conn = mysqli_connect($host, $username, $password, $database);

  // Check connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Sanitize and escape user input (prevent SQL injection)
  $sanitizedSellerId = mysqli_real_escape_string($conn, $sellerId);

  // Build the SQL query
  $sql = "SELECT * FROM users WHERE id = '$sanitizedSellerId'";

  // Execute the query
  $result = mysqli_query($conn, $sql);

  // Check if a seller was found
  if (mysqli_num_rows($result) === 1) {
    $seller = mysqli_fetch_assoc($result);

    // Display seller details using HTML (replace with your desired structure)

    echo "<h3>Seller Details</h3>";
    echo "<p>Name: " . $seller['name'] . "</p>"; // Replace with appropriate column names
    echo "<p>Email: " . $seller['email'] . "</p>";  // Replace with appropriate column names
    // ... Add more details as needed

  } else {
    echo "No seller found with ID: $sellerId";
  }

  // Close the database connection
  mysqli_close($conn);
}

// Assuming the seller ID is retrieved from the form submission
$sellerId = $_POST['seller_id'];

// Call the function to view seller details
viewSellerDetails($sellerId);

?>

<?php include 'footer.php'; ?> 
