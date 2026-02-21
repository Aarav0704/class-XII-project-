<?php
session_start();
if (!isset($_SESSION['teacher_id'])) { header("Location: teacher_login.php"); exit; }
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="style.css">
<link rel="icon" type="image/png" href="favicon.png">
<title>Teacher Dashboard</title>
</head>
<body>
    <div class="container">
        <h2>Welcome, Teacher <?php echo $_SESSION['teacher_name']; ?></h2>
        <hr>
        <a href="create_exam.php" class="btn">Take/Create New Exam</a>
        <a href="evaluate_student.php" class="btn">Evaluate Submissions</a>
        <br><br>
        <a href="index.php" class="btn" style="background-color: #dc3545;">Logout</a>
    </div>
</body>
</html>