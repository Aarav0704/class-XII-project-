<?php
session_start();
include 'db_connect.php';
$s_id = $_SESSION['student_id'];
$e_id = $_POST['exam_id'];

// Create a main submission record
mysqli_query($conn, "INSERT INTO submissions (student_id, exam_id, status) VALUES ('$s_id', '$e_id', 'pending')");
$sub_id = mysqli_insert_id($conn);

// Save individual answers
foreach ($_POST['answers'] as $q_id => $answer_text) {
    mysqli_query($conn, "INSERT INTO student_answers (submission_id, question_id, answer_text) VALUES ('$sub_id', '$q_id', '$answer_text')");
}

header("Location: student_dashboard.php");
?>