<?php
session_start();
include 'db_connect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM students WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['student_id'] = $row['student_id'];
        $_SESSION['student_name'] = $row['full_name'];
        header("Location: student_dashboard.php");
    } else {
        echo "<script>alert('Invalid Email or Password');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="style.css">
<link rel="icon" type="image/png" href="favicon.png">
<title>Student Login</title>
</head>
<body>
    <div class="container">
        <h2>Student Login</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="btn">Login</button>
        </form>
        <a href="student_signup.php">Don't have an account? Sign up</a>
    </div>
</body>
</html>