<?php
require_once(__DIR__ . '/../../models/user_model.php');
require_once(__DIR__ . '/activity_log_controller.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// CREATE
function create_user_controller($username, $password, $role_id) {
    $result = insert_user($username, $password, $role_id);
    if ($result) {
        $current_user_id = $_SESSION['user_id'];
        create_log_controller($current_user_id, "Add User", "Menambahkan user $username dengan role $role_id");
    }
    return $result;
}

// READ
function read_users_controller() {
    return get_all_users();
}

// READ by ID
function read_user_by_id_controller($user_id) {
    return get_user_by_id($user_id);
}

// UPDATE
function update_user_controller($user_id, $username, $password, $role_id) {
    $result = update_user($user_id, $username, $password, $role_id);
    if ($result) {
        $current_user_id = $_SESSION['user_id'];
        create_log_controller($current_user_id, "Update User", "Mengubah user ID $user_id menjadi $username dengan role $role_id");
    }
    return $result;
}

// DELETE
function delete_user_controller($user_id) {
    $result = delete_user($user_id);
    if ($result) {
        $current_user_id = $_SESSION['user_id'];
        create_log_controller($current_user_id, "Delete User", "Menghapus user ID $user_id");
    }
    return $result;
}
?>