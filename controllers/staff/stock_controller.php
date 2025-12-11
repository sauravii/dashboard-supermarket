<?php
require_once(__DIR__ . '/../../models/stock_model.php');

// READ
function read_all_stocks_controller() {
  return get_all_stocks();
}

// CREATE
function add_stock_controller($product_id, $supplier_id, $quantity, $user_id) {
  return add_stock($product_id, $supplier_id, $quantity, $user_id);
}

// UPDATE
function remove_stock_controller($product_id, $quantity, $user_id, $reason) {
  return remove_stock($product_id, $quantity, $user_id, $reason);
}
?>
