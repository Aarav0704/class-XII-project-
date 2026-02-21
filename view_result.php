<?php
session_start();
include 'db_connect.php';
$sub_id = $_GET['sub_id'];
$res = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM submissions WHERE submission_id='$sub_id'"));
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="style.css">
<link rel="icon" type="image/png" href="favicon.png">
<title>View Result</title>
</head>
<body>
    <div class="container">
        <h2>Your Result</h2>
        <h3>Total Score: <?php echo $res['total_score']; ?></h3>
        <p>Status: <?php echo strtoupper($res['status']); ?></p>
        <a href="student_dashboard.php" class="btn">Back to Dashboard</a>
    </div>
</body>
</html>