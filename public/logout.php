<?php
session_start();

require "../config/db.php";
require "../controllers/admin/activity_log_controller.php";

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];

    create_log_controller($user_id, "Logout", "User $username logout dari sistem");
}

session_unset();
session_destroy();

header("Location: login.php");
exit;
?>
