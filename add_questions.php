<?php
session_start();
include 'db_connect.php';
$exam_id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question = $_POST['question'];
    $marks = $_POST['marks'];
    mysqli_query($conn, "INSERT INTO questions (exam_id, question_text, max_marks) VALUES ('$exam_id', '$question', '$marks')");
}
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="style.css">
<link rel="icon" type="image/png" href="favicon.png">
<title>Assign Questions</title>
</head>
<body>
    <div class="container">
        <h2>Add Questions</h2>
        <form method="POST">
            <textarea name="question" placeholder="Enter Question here..." style="width:100%; height:80px;" required></textarea>
            <input type="number" name="marks" placeholder="Marks" required>
            <button type="submit" class="btn">Add Question</button>
        </form>
        <hr>
        <a href="teacher_dashboard.php" class="btn" style="background-color:green;">Finish & Return to Dashboard</a>
    </div>
</body>
</html>