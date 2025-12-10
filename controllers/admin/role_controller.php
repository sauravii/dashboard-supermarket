<?php
require_once(__DIR__ . '/../../models/role_model.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// CREATE
function create_role_controller($role_name) {
    $result = insert_role($role_name);
    if ($result) {
        $current_user_id = $_SESSION['user_id'];
        create_log_controller($current_user_id, "Add Role", "Menambahkan role $role_name");
    }
    return $result;
}

// READ
function read_roles_controller() {
  return get_all_roles();
}

// READ by ID
function read_role_by_id_controller($role_id) {
  return get_role_by_id($role_id);
}

// UPDATE
function update_role_controller($role_id, $role_name) {
    $result = update_role($role_id, $role_name);
    if ($result) {
        $current_user_id = $_SESSION['user_id'];
        create_log_controller($current_user_id, "Edit Role", "Mengubah role ID $role_id menjadi $role_name");
    }
    return $result;
}

// DELETE
function delete_role_controller($role_id) {
    $result = delete_role($role_id);
    if ($result) {
        $current_user_id = $_SESSION['user_id'];
        create_log_controller($current_user_id, "Delete Role", "Menghapus role ID $role_id");
    }
    return $result;
}


