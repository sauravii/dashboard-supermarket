<?php
require_once(__DIR__ . '/../../models/role_model.php');

// READ
function read_roles_controller() {
  return get_all_roles();
}
