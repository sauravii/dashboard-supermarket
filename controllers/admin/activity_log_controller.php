<?php
require_once(__DIR__ . '/../../models/activity_log_model.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// CREATE
function create_log_controller($user_id, $action, $description) {
    return insert_log($user_id, $action, $description);
}

// READ
function read_logs_controller() {
    return get_all_logs();
}
?>
