<?php
include 'config.php';
session_start();
$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
    header('location:login.php');
    exit;
}
$query_bookgenre_demographics = "
    SELECT 
        bookgenre, 
        COUNT(*) as count
    FROM `products`
    WHERE bookgenre IS NOT NULL
    GROUP BY bookgenre
";
$result_bookgenre_demographics = mysqli_query($conn, $query_bookgenre_demographics) or die('Book Genre demographics query failed');
$demographics_bookgenre_data = [];
while ($row = mysqli_fetch_assoc($result_bookgenre_demographics)) {
    $demographics_bookgenre_data[] = $row;
}


$query_age_demographics = "
    SELECT 
        COUNT(*) as count, 
        CASE
            WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) <= 21 THEN '21 and below'
            ELSE '22 and above'
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

$query_verification_status = "
    SELECT 
        verified, 
        COUNT(*) as count
    FROM `users`
    GROUP BY verified
";
$result_verification_status = mysqli_query($conn, $query_verification_status) or die('Verification status query failed');
$verification_status_data = [];
while ($row = mysqli_fetch_assoc($result_verification_status)) {
    $verification_status_data[] = $row;
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

   <!-- Chart.js library -->
   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

   <!-- jsPDF library -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

   <!-- jsPDF autoTable plugin -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>

</head>
<body>
   
<?php include 'admin_header.php'; ?>
 



<section class="analytics">

   <h1 class="title">Overall Analytics Report</h1>

   <!-- Book Genre Demographics -->
   <h2 class="sub-title">Book Genre Demographics</h2>
   <div class="box-container">
      <?php if (!empty($demographics_bookgenre_data)) { ?>
         <div class="bar-graph">
            <h3 class="graph-title">Book Genre Demographics of Users</h3>
            <div class="bar-container">
               <?php foreach ($demographics_bookgenre_data as $data) { ?>
               <div class="bar">
                  <div class="label"><?php echo $data['bookgenre']; ?></div>
                  <div class="fill" style="width: <?php echo ($data['count'] * 10) . 'px'; ?>"></div>
                  <div class="count"><?php echo $data['count']; ?></div>
               </div>
               <?php } ?>
            </div>
            <br>
         <div class="chart-container" style="width: 500px; height: 300px;">
            <canvas id="bookgenreDemographicsChart" width="200" height="200"></canvas>
         </div>
         </div>
      <?php } else { ?>
         <p class="empty">No bookgenre demographic data available!</p>
      <?php } ?>
   </div>



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
         <div class="chart-container" style="width: 270px; height: 200px;">
            <canvas id="ageDemographicsChart" width="200" height="200"></canvas>
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
         <div class="chart-container" style="width: 200px; height: 200px;">
            <canvas id="genderDemographicsChart" width="200" height="200"></canvas>
         </div>
         </div>
      <?php } else { ?>
         <p class="empty">No gender demographic data available!</p>
      <?php } ?>
   </div>

   <!-- User Verification Status -->
   <h2 class="sub-title">User Verification Status</h2>
   <div class="box-container">
      <?php if (!empty($verification_status_data)) { ?>
         <div class="bar-graph">
            <h3 class="graph-title">Verification Status of Users</h3>
            <div class="bar-container">
               <?php foreach ($verification_status_data as $data) { ?>
               <div class="bar">
                  <div class="label"><?php echo $data['verified'] ? 'Verified' : 'Unverified'; ?></div>
                  <div class="fill" style="width: <?php echo ($data['count'] * 10) . 'px'; ?>"></div>
                  <div class="count"><?php echo $data['count']; ?></div>
               </div>
               <?php } ?>
            </div>
         <div class="chart-container" style="width: 220px; height: 200px;">
            <canvas id="verificationStatusChart" width="220" height="200"></canvas>
         </div>
         </div>
      <?php } else { ?>
         <p class="empty">No verification status data available!</p>
      <?php } ?>
   </div>
   

   <button id="generatePDF" class="btn" style="display: block; margin: 0 auto;">Generate Overall Analytics Report PDF</button>

</section>

<!-- custom admin js file link -->
<script src="js/admin_script.js"></script>

<script>
// Book Genre Demographics Data
const bookgenreData = {
    labels: <?php echo json_encode(array_column($demographics_bookgenre_data, 'bookgenre')); ?>,
    datasets: [{
        label: 'Book Genre Demographics',
        data: <?php echo json_encode(array_column($demographics_bookgenre_data, 'count')); ?>,
        backgroundColor: ['#FF0000', '#00FF00' , '#0000FF', ' #00FFFF', '#FF00FF', '#FFFF00', '#FFA500', '#800080',  '#008080', '#FFC0CB', '#E6E6FA', '#A52A2A', '#800000', '#000080', '#808000', '#4B0082', '#8B0000', '#006400', '#00008B', '#008B8B', '#8B008B', '#B8860B', ' #FF8C00', '#483D8B', '#008080', '#FF1493', '#708090', '#D3D3D3', '#A9A9A9', '#F5F5DC', '#FFFFF0', '#FF7F50', '#2E8B57'],
        hoverOffset: 4
    }]
};

// Age Demographics Data
const ageData = {
    labels: <?php echo json_encode(array_column($demographics_age_data, 'age_group')); ?>,
    datasets: [{
        label: 'Age Demographics',
        data: <?php echo json_encode(array_column($demographics_age_data, 'count')); ?>,
        backgroundColor: ['#123e45', '#36a2eb'],
        hoverOffset: 4
    }]
};

// Gender Demographics Data
const genderData = {
    labels: <?php echo json_encode(array_column($demographics_gender_data, 'gender')); ?>,
    datasets: [{
        label: 'Gender Demographics',
        data: <?php echo json_encode(array_column($demographics_gender_data, 'count')); ?>,
        backgroundColor: ['#123e45', '#36a2eb'],
        hoverOffset: 4
    }]
};

// Verification Status Data
const verificationData = {
    labels: ['Unverified', 'Verified'],
    datasets: [{
        label: 'Verification Status',
        data: <?php echo json_encode(array_column($verification_status_data, 'count')); ?>,
        backgroundColor: ['#123e45', '#36a2eb'],
        hoverOffset: 4
    }]
};

// Configurations
const configBookGenre = {
    type: 'pie',
    data: bookgenreData,
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
};


const configAge = {
    type: 'pie',
    data: ageData,
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
};

const configGender = {
    type: 'pie',
    data: genderData,
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
};

const configVerification = {
    type: 'pie',
    data: verificationData,
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
};

// Render Charts
window.onload = function() {
    const bookgenreCtx = document.getElementById('bookgenreDemographicsChart').getContext('2d');
    new Chart(bookgenreCtx, configBookGenre);

    const ageCtx = document.getElementById('ageDemographicsChart').getContext('2d');
    new Chart(ageCtx, configAge);

    const genderCtx = document.getElementById('genderDemographicsChart').getContext('2d');
    new Chart(genderCtx, configGender);

    const verificationCtx = document.getElementById('verificationStatusChart').getContext('2d');
    new Chart(verificationCtx, configVerification);
};


// Generate PDF report
document.getElementById('generatePDF').addEventListener('click', function() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    // Function to get current date in the format "Month Day, Year"
    function getCurrentDate() {
        const now = new Date();
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return now.toLocaleDateString('en-US', options);
    }

    // Function to add footer
    function addFooter() {
        const pageCount = doc.internal.getNumberOfPages();
        for (let i = 1; i <= pageCount; i++) {
            doc.setPage(i);
            doc.setFontSize(10); 
            doc.text(10, doc.internal.pageSize.height - 10, "Bookworms Connect");
            doc.text(doc.internal.pageSize.width - 70, doc.internal.pageSize.height - 10, getCurrentDate());
        }
    }

    doc.text('Overall Analytics Report', 10, 10);

    // Add Book Genre Demographics
   doc.text('Book Genre Demographics', 10, 20);
   const bookgenreRows = <?php echo json_encode($demographics_bookgenre_data); ?>.map(data => [data.bookgenre, data.count]);
   doc.autoTable({
    head: [['Book Genre Group', 'Count']],
    body: bookgenreRows,
    startY: 25,
   });


    // Add Age Demographics
    doc.text('User Age Demographics', 10, doc.autoTable.previous.finalY + 10);
    const ageRows = <?php echo json_encode($demographics_age_data); ?>.map(data => [data.age_group, data.count]);
    doc.autoTable({
        head: [['Age Group', 'Count']],
        body: ageRows,
        startY: doc.autoTable.previous.finalY + 15
    });

    // Add Gender Demographics
    doc.text('User Gender Demographics', 10, doc.autoTable.previous.finalY + 10);
    const genderRows = <?php echo json_encode($demographics_gender_data); ?>.map(data => [data.gender, data.count]);
    doc.autoTable({
        head: [['Gender', 'Count']],
        body: genderRows,
        startY: doc.autoTable.previous.finalY + 15
    });

    // Add Verification Status
    doc.text('User Verification Status (0-Unverified 1-Verified)', 10, doc.autoTable.previous.finalY + 10);
    const verificationRows = <?php echo json_encode($verification_status_data); ?>.map(data => [
        data.verified,  // Corrected order
        data.count
    ]);
    doc.autoTable({
        head: [['Verification Status', 'Count']],
        body: verificationRows,
        startY: doc.autoTable.previous.finalY + 15
    });

    addFooter(); // Call function to add footer

    doc.save('Analytics_Report.pdf');
});

</script>

</body>
</html>

