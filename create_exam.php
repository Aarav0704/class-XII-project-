<?php
session_start();
include 'db_connect.php';
if (!isset($_SESSION['teacher_id'])) { header("Location: teacher_login.php"); exit; }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $t_id = $_SESSION['teacher_id'];
    $sql = "INSERT INTO exams (teacher_id, exam_title) VALUES ('$t_id', '$title')";
    if (mysqli_query($conn, $sql)) {
        $exam_id = mysqli_insert_id($conn);
        header("Location: add_questions.php?id=$exam_id");
    }
}
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="style.css">
<link rel="icon" type="image/png" href="favicon.png">
<title>Create New Exam</title>
</head>
<body>
    <div class="container">
        <h2>Create New Exam</h2>
        <form method="POST">
            <input type="text" name="title" placeholder="Exam Title (e.g., Computer Science Midterm)" required>
            <button type="submit" class="btn">Create & Add Questions</button>
        </form>
    </div>
</body>
</html>