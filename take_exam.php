<?php
session_start();
include 'db_connect.php';
$exam_id = $_GET['id'];
$questions = mysqli_query($conn, "SELECT * FROM questions WHERE exam_id='$exam_id'");
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="style.css">
<link rel="icon" type="image/png" href="favicon.png">
<title>Take Exam</title>
</head>
<body>
    <div class="container">
        <h2>Exam Paper</h2>
        <form action="submit_exam.php" method="POST">
            <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>">
            <?php while($q = mysqli_fetch_assoc($questions)) { ?>
                <p><strong><?php echo $q['question_text']; ?> (<?php echo $q['max_marks']; ?> Marks)</strong></p>
                <textarea name="answers[<?php echo $q['question_id']; ?>]" style="width:100%; height:100px;" required></textarea>
                <hr>
            <?php } ?>
            <button type="submit" class="btn">Submit Exam</button>
        </form>
    </div>
</body>
</html>