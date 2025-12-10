<?php
require_once(__DIR__ . '/../config/db.php');

// get all role
function get_all_roles() {
  global $conn;
  $query = "SELECT * FROM roles ORDER BY role_id ASC";
  $result = mysqli_query($conn, $query);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
