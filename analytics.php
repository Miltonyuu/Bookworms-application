<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
    exit; // Add exit to stop further execution
}

// Fetch user age demographics data
$query_age_demographics = "
    SELECT 
        COUNT(*) as count, 
        CASE
            WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN 18 AND 25 THEN '18-25'
            WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN 26 AND 35 THEN '26-35'
            ELSE '36 and above'
        END as age_group
    FROM `users`
    WHERE birthdate IS NOT NULL
    GROUP BY age_group
";

$result_age_demographics = mysqli_query($conn, $query_age_demographics) or die('Age demographics query failed');
$demographics_age_data = [];
while ($row = mysqli_fetch_assoc($result_age_demographics)) {
    $demographics_age_data[] = $row;
}

// Fetch user gender demographics data
$query_gender_demographics = "
    SELECT 
        gender, 
        COUNT(*) as count
    FROM `users`
    WHERE gender IS NOT NULL
    GROUP BY gender
";

$result_gender_demographics = mysqli_query($conn, $query_gender_demographics) or die('Gender demographics query failed');
$demographics_gender_data = [];
while ($row = mysqli_fetch_assoc($result_gender_demographics)) {
    $demographics_gender_data[] = $row;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Analytics</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin-section/admin_style.css">

   <!-- custom admin bar graph css -->
   <link rel="stylesheet" href="css/admin-section/bar_graph.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="analytics">

   <h1 class="title">Overall Analytics Report</h1>

   <!-- User Age Demographics -->
   <h2 class="sub-title">User Age Demographics</h2>
   <div class="box-container">
      <?php if (!empty($demographics_age_data)) { ?>
         <div class="bar-graph">
            <h3 class="graph-title">Age Demographics of Users</h3>
            <div class="bar-container">
               <?php foreach ($demographics_age_data as $data) { ?>
               <div class="bar">
                  <div class="label"><?php echo $data['age_group']; ?></div>
                  <div class="fill" style="width: <?php echo ($data['count'] * 10) . 'px'; ?>"></div>
                  <div class="count"><?php echo $data['count']; ?></div>
               </div>
               <?php } ?>
            </div>
         </div>
      <?php } else { ?>
         <p class="empty">No age demographic data available!</p>
      <?php } ?>
   </div>

   <!-- User Gender Demographics -->
   <h2 class="sub-title">User Gender Demographics</h2>
   <div class="box-container">
      <?php if (!empty($demographics_gender_data)) { ?>
         <div class="bar-graph">
            <h3 class="graph-title">Gender Demographics of Users</h3>
            <div class="bar-container">
               <?php foreach ($demographics_gender_data as $data) { ?>
               <div class="bar">
                  <div class="label"><?php echo $data['gender']; ?></div>
                  <div class="fill" style="width: <?php echo ($data['count'] * 10) . 'px'; ?>"></div>
                  <div class="count"><?php echo $data['count']; ?></div>
               </div>
               <?php } ?>
            </div>
         </div>
      <?php } else { ?>
         <p class="empty">No gender demographic data available!</p>
      <?php } ?>
   </div>

</section>

<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>
