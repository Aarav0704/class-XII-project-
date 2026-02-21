<?php
include 'db_connect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $neb = $_POST['neb'];
    // In a real app, use password_hash(). Using simple md5 for this mini-project.
    $password = md5($_POST['password']); 

    $sql = "INSERT INTO students (full_name, neb_symbol_no, email, password) VALUES ('$name', '$neb', '$email', '$password')";
    if (mysqli_query($conn, $sql)) {
        header("Location: student_login.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="style.css">
<link rel="icon" type="image/png" href="favicon.png">
<title>Student Sign Up</title>
</head>
<body>
    <div class="container">
        <h2>Student Sign Up</h2>
        <form method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="text" name="neb" placeholder="NEB Symbol No" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="btn">Sign Up</button>
        </form>
        <a href="student_login.php">Already have an account? Login here</a>
    </div>
</body>
</html>