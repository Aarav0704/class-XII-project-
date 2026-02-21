<?php
session_start();
include 'db_connect.php';

// Redirect if not logged in
if (!isset($_SESSION['student_id'])) { 
    header("Location: student_login.php"); 
    exit; 
}

$student_id = $_SESSION['student_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <link rel="icon" type="image/png" href="favicon.png">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo $_SESSION['student_name']; ?></h2>
        <hr>

        <h3>Available Exams</h3>
        <table border="1" width="100%" style="border-collapse: collapse; margin-bottom: 20px;">
            <tr style="background-color: #f2f2f2;">
                <th>Exam Title</th>
                <th>Action</th>
            </tr>
            <?php
            // Fetch exams that the student has NOT submitted yet
            $exam_query = "SELECT * FROM exams WHERE exam_id NOT IN 
                           (SELECT exam_id FROM submissions WHERE student_id = '$student_id')";
            $exams = mysqli_query($conn, $exam_query);

            if (mysqli_num_rows($exams) > 0) {
                while($row = mysqli_fetch_assoc($exams)) {
                    // Note: Ensure your file is named take_exam.php or take_exm.php to match your sidebar
                    echo "<tr>
                            <td style='padding:10px;'>{$row['exam_title']}</td>
                            <td style='padding:10px;'><a href='take_exam.php?id={$row['exam_id']}' class='btn' style='padding: 5px 10px; font-size: 12px;'>Start Exam</a></td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='2' style='padding:10px;'>No new exams available.</td></tr>";
            }
            ?>
        </table>

        <h3>Your Results</h3>
        <table border="1" width="100%" style="border-collapse: collapse;">
            <tr style="background-color: #f2f2f2;">
                <th>Exam Title</th>
                <th>Status</th>
                <th>Score</th>
                <th>Details</th>
            </tr>
            <?php
            // Fetch exams already taken by this student
            $res_query = "SELECT s.submission_id, e.exam_title, s.status, s.total_score 
                          FROM submissions s 
                          JOIN exams e ON s.exam_id = e.exam_id 
                          WHERE s.student_id = '$student_id'";
            $results = mysqli_query($conn, $res_query);

            if (mysqli_num_rows($results) > 0) {
                while($res = mysqli_fetch_assoc($results)) {
                    $score = ($res['status'] == 'graded') ? $res['total_score'] : "Pending";
                    echo "<tr>
                            <td style='padding:10px;'>{$res['exam_title']}</td>
                            <td style='padding:10px;'>" . strtoupper($res['status']) . "</td>
                            <td style='padding:10px;'>$score</td>
                            <td style='padding:10px;'>";
                    if($res['status'] == 'graded') {
                        echo "<a href='view_result.php?sub_id={$res['submission_id']}'>View Details</a>";
                    } else {
                        echo "Waiting for Evaluation";
                    }
                    echo "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='4' style='padding:10px;'>No exams submitted yet.</td></tr>";
            }
            ?>
        </table>

        <br>
        <a href="index.php" class="btn" style="background-color: #dc3545;">Logout</a>
    </div>
</body>
</html>