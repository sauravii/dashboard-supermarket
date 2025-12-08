<?php
session_start();
require "../config/db.php";

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE username='$username' LIMIT 1";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);

    if ($password === $row['password']) {

        //  session
        $_SESSION['logged_in'] = true;
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];

        if ($row['role'] == 'admin') {
            header("Location: /supermarket-app/public/admin/dashboard.php");
        } else {
            header("Location: /supermarket-app/public/staff/dashboard.php");
        }
        exit;
    }
}

header("Location: ../public/login.php?error=1");
exit;
?>
