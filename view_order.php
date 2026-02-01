<?php
include "config/db.php";

// Angalia order id
$order_id = 2;

// Pata order info
$sql_order = "SELECT * FROM orders WHERE id = $order_id";
$order_result = $conn->query($sql_order);

if ($order_result->num_rows > 0) {
    $order = $order_result->fetch_assoc();
    echo "Order ID: " . $order['id'] . " - Total: Tsh " . number_format($order['total_price'], 0) . " - Status: " . $order['status'] . "<br><br>";

    // Pata items za order
    $sql_items = "SELECT oi.quantity, oi.price, f.name 
                  FROM order_items oi 
                  JOIN food_items f ON oi.food_id = f.id 
                  WHERE oi.order_id = $order_id";
    $items_result = $conn->query($sql_items);

    if ($items_result->num_rows > 0) {
        while($item = $items_result->fetch_assoc()) {
            echo "Food: " . $item['name'] . " | Quantity: " . $item['quantity'] . " | Price: Tsh " . number_format($item['price'], 0) . "<br>";
        }
    } else {
        echo "No items found for this order.";
    }

} else {
    echo "Order not found.";
}
?>