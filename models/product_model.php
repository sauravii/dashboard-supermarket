<?php
require_once(__DIR__ . '/../config/db.php');

// get all product
function get_all_products() {
  global $conn;
  $query = "
    SELECT p.product_id, p.product_name,
           b.brand_name,
           c.category_name,
           s.supplier_name
    FROM product p
    JOIN brand b ON p.brand_id = b.brand_id
    JOIN category c ON p.category_id = c.category_id
    JOIN supplier s ON p.supplier_id = s.supplier_id
    ORDER BY p.product_id ASC
  ";
  $result = mysqli_query($conn, $query);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// insert product
function insert_product($product_name, $brand_id, $category_id, $supplier_id) {
  global $conn;
  $query = "INSERT INTO product (product_name, brand_id, category_id, supplier_id) VALUES (?, ?, ?, ?)";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "siii", $product_name, $brand_id, $category_id, $supplier_id);
  return mysqli_stmt_execute($stmt);
}

// get product by ID
function get_product_by_id($product_id) {
  global $conn;
  $query = "SELECT * FROM product WHERE product_id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "i", $product_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  return mysqli_fetch_assoc($result);
}

// update product
function update_product($product_id, $product_name, $brand_id, $category_id, $supplier_id) {
  global $conn;
  $query = "UPDATE product SET product_name = ?, brand_id = ?, category_id = ?, supplier_id = ? WHERE product_id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "siiii", $product_name, $brand_id, $category_id, $supplier_id, $product_id);
  return mysqli_stmt_execute($stmt);
}

// delete product
function delete_product($product_id) {
  global $conn;
  $query = "DELETE FROM product WHERE product_id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "i", $product_id);
  return mysqli_stmt_execute($stmt);
}

?>