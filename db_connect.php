<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "online_exam_db"; // Make sure your database is named this in phpMyAdmin

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>