<?php
session_start();
include 'db_connect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password']; 

    $sql = "SELECT * FROM teachers WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['teacher_id'] = $row['teacher_id'];
        $_SESSION['teacher_name'] = $row['full_name'];
        header("Location: teacher_dashboard.php");
    } else {
        echo "<script>alert('Invalid Credentials');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="style.css">
<link rel="icon" type="image/png" href="favicon.png">
<title>Teacher Login</title>
</head>
<body>
    <div class="container">
        <h2>Teacher Login</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Teacher Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</body>
</html>