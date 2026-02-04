<?php
session_start();
include "config/db.php";

/* Only logged-in customers */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* Fetch orders for this customer */
$sql_orders = "SELECT * FROM orders WHERE user_id = $user_id ORDER BY created_at DESC";
$result_orders = $conn->query($sql_orders);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Orders</title>
    <style>
        body { font-family: Arial; padding:20px; background:#f7f7f7; }
        table { width:100%; border-collapse: collapse; margin-top:20px; }
        th, td { padding:10px; border:1px solid #ccc; text-align:left; }
        th { background:#007bff; color:#fff; }
        h2 { color:#333; }
    </style>
</head>
<body>

<h2>My Orders</h2>

<?php
if ($result_orders && $result_orders->num_rows > 0) {
    while ($order = $result_orders->fetch_assoc()) {
        echo "<h3>Order ID: {$order['id']} | Total: Tsh {$order['total_price']} | Status: {$order['status']} | Date: {$order['created_at']}</h3>";

if ($order['status'] === 'pending') {
    echo "<form method='post' action='cancel_order.php' style='margin-bottom:10px;'>
            <input type='hidden' name='order_id' value='{$order['id']}'>
            <button type='submit' name='cancel_order'>Cancel Order</button>
          </form>";
}

        // Fetch items for this order
        $order_id = $order['id'];
        $sql_items = "SELECT oi.quantity, oi.price, fi.name 
                      FROM order_items oi
                      JOIN food_items fi ON oi.food_id = fi.id
                      WHERE oi.order_id = $order_id";
        $res_items = $conn->query($sql_items);

        if ($res_items && $res_items->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Product</th><th>Quantity</th><th>Price (Tsh)</th></tr>";
            while ($item = $res_items->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$item['name']}</td>";
                echo "<td>{$item['quantity']}</td>";
                echo "<td>{$item['price']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No items found for this order.</p>";
        }
    }
} else {
    echo "<p>You have not placed any orders yet.</p>";
}
?>

<a href="customer_products.php">Back to Products</a>

</body>
</html>