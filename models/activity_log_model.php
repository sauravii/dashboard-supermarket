<?php
require_once(__DIR__ . '/../config/db.php');

// get IP address
function get_client_ip() {
    if (isset($_SERVER['HTTP_CLIENT_IP'])) return $_SERVER['HTTP_CLIENT_IP'];
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) return $_SERVER['HTTP_X_FORWARDED_FOR'];
    if (isset($_SERVER['HTTP_X_FORWARDED'])) return $_SERVER['HTTP_X_FORWARDED'];
    if (isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    if (isset($_SERVER['HTTP_FORWARDED_FOR'])) return $_SERVER['HTTP_FORWARDED_FOR'];
    if (isset($_SERVER['HTTP_FORWARDED'])) return $_SERVER['HTTP_FORWARDED'];
    if (isset($_SERVER['REMOTE_ADDR'])) return $_SERVER['REMOTE_ADDR'];
    return 'UNKNOWN';
}

// insert log
function insert_log($user_id, $action, $description) {
    global $conn;
    $ip_address = get_client_ip();
    $device_info = $_SERVER['HTTP_USER_AGENT'];

    $query = "INSERT INTO activity_log (user_id, action, description, ip_address, device_info) 
              VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "issss", $user_id, $action, $description, $ip_address, $device_info);
    return mysqli_stmt_execute($stmt);
}

// get all logs 
function get_all_logs() {
    global $conn;
    $query = "SELECT a.log_id, u.username, r.role_name, a.action, a.description, 
                     a.ip_address, a.device_info, a.created_at
              FROM activity_log a
              JOIN users u ON a.user_id = u.user_id
              JOIN roles r ON u.role_id = r.role_id
              ORDER BY a.created_at DESC";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>
