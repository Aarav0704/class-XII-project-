<?php
session_start();
include 'db_connect.php';
if (!isset($_SESSION['teacher_id'])) { header("Location: teacher_login.php"); exit; }

// Save Marks Logic
if (isset($_POST['save_marks'])) {
    $sub_id = $_POST['sub_id'];
    
    // Safety check: Don't process if already graded
    $check = mysqli_query($conn, "SELECT status FROM submissions WHERE submission_id = '$sub_id'");
    $status_row = mysqli_fetch_assoc($check);
    
    if($status_row['status'] !== 'graded') {
        $total = 0;
        foreach ($_POST['marks'] as $ans_id => $score) {
            mysqli_query($conn, "UPDATE student_answers SET marks_awarded='$score' WHERE answer_id='$ans_id'");
            $total += $score;
        }
        mysqli_query($conn, "UPDATE submissions SET status='graded', total_score='$total' WHERE submission_id='$sub_id'");
    }
    header("Location: evaluate_student.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="favicon.png">
    <title>Check answers</title>
</head>
<body>
<div class="container">
    <h2>Evaluation Panel</h2>
    
    <table border="1" width="100%" style="border-collapse: collapse;">
        <tr style="background:#f2f2f2;"><th>Student</th><th>Exam</th><th>Status</th><th>Action</th></tr>
        <?php
        $res = mysqli_query($conn, "SELECT s.submission_id, st.full_name, e.exam_title, s.status FROM submissions s JOIN students st ON s.student_id = st.student_id JOIN exams e ON s.exam_id = e.exam_id");
        while($row = mysqli_fetch_assoc($res)) { ?>
            <tr>
                <td><?php echo $row['full_name']; ?></td>
                <td><?php echo $row['exam_title']; ?></td>
                <td><strong><?php echo strtoupper($row['status']); ?></strong></td>
                <td>
                    <?php if($row['status'] == 'pending'): ?>
                        <a href="evaluate_student.php?id=<?php echo $row['submission_id']; ?>" class="btn" style="padding:2px 10px; font-size:12px;">Grade</a>
                    <?php else: ?>
                        <span style="color:green;">✔ Completed</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php } ?>
    </table>

    <?php 
    if(isset($_GET['id'])) { 
        $id = $_GET['id'];
        
        // Final Security: Only show form if the submission is actually pending
        $status_check = mysqli_query($conn, "SELECT status FROM submissions WHERE submission_id = '$id'");
        $current_status = mysqli_fetch_assoc($status_check);

        if($current_status['status'] == 'pending') {
            $ans = mysqli_query($conn, "SELECT sa.*, q.question_text, q.max_marks FROM student_answers sa JOIN questions q ON sa.question_id = q.question_id WHERE sa.submission_id = '$id'");
        ?>
            <hr><h3>Grading Answers</h3>
            <form method="POST">
                <input type="hidden" name="sub_id" value="<?php echo $id; ?>">
                <?php while($a = mysqli_fetch_assoc($ans)) { ?>
                    <p>Q: <?php echo $a['question_text']; ?> (Max: <?php echo $a['max_marks']; ?>)</p>
                    <p><i>Ans: <?php echo $a['answer_text']; ?></i></p>
                    <input type="number" name="marks[<?php echo $a['answer_id']; ?>]" max="<?php echo $a['max_marks']; ?>" min="0" required>
                <?php } ?>
                <br><button type="submit" name="save_marks" class="btn">Submit Score</button>
            </form>
        <?php 
        } else {
            echo "<p style='color:red; margin-top:20px;'>This exam has already been graded and cannot be modified.</p>";
        }
    } 
    ?>
    <br><a href="teacher_dashboard.php">Back</a>
</div>
</body>
</html>