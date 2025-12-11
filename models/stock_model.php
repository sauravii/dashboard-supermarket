<?php
require_once(__DIR__ . '/../config/db.php');

// get all stocks
function get_all_stocks() {
  global $conn;
  $query = "
    SELECT ts.product_id, ts.total_stock, ts.unit_id, ts.last_updated_at,
           p.product_name, p.supplier_id,
           u.unit_name, s.supplier_name
    FROM total_stock ts
    JOIN product p ON ts.product_id = p.product_id
    JOIN qty_unit u ON ts.unit_id = u.unit_id
    JOIN supplier s ON p.supplier_id = s.supplier_id
    ORDER BY ts.product_id ASC
  ";
  $result = mysqli_query($conn, $query);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// add stock
function add_stock($product_id, $supplier_id, $quantity, $unit_id) {
    global $conn;

    $stmt = $conn->prepare("UPDATE total_stock SET total_stock = total_stock + ? WHERE product_id = ?");
    $stmt->bind_param("ii", $quantity, $product_id);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO restock_history (product_id, supplier_id, quantity_change, unit_id, log_date) 
                            VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("iiii", $product_id, $supplier_id, $quantity, $unit_id);
    $stmt->execute();
    $stmt->close();
}


// remove stock
function remove_stock($product_id, $quantity, $unit_id, $reason) {
    global $conn;

    $stmt = $conn->prepare("UPDATE total_stock SET total_stock = total_stock - ? WHERE product_id = ?");
    $stmt->bind_param("ii", $quantity, $product_id);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO stock_adjustment (product_id, unit_id, quantity_removed, reason, created_at) 
                            VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("iiis", $product_id, $unit_id, $quantity, $reason);
    $stmt->execute();
    $stmt->close();
}
?>
