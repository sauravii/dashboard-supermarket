<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: /supermarket-app/public/login.php");
    exit;
}

if ($_SESSION['role'] !== 'admin') {
    header("Location: Location: /supermarket-app/public/staff/dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Hello Admin</h1>
    <p>Welcome to the admin dashboard</p>

    <a href="../logout.php">Logout</a>
</body>
</html>
