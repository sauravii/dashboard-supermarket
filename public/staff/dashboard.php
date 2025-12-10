<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: /supermarket-app/public/login.php");
    exit;
}

if ($_SESSION['role_id'] != 2) { 
    header("Location: /supermarket-app/public/admin/dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Staff Dashboard</title>
</head>
<body>
    <h1>Hello Staff</h1>
    <p>Welcome to the staff dashboard</p>

    <a href="../logout.php">Logout</a>
</body>
</html>
