<?php
session_start();
include "config/db.php";

/* Check if customer is logged in */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.php");
    exit;
}

if (isset($_POST['place_order'])) {

    $user_id = $_SESSION['user_id'];
    $food_id = $_POST['product_id']; // form still sends product_id
    $quantity = $_POST['quantity'];

    // Get product price
    $sql_product = "SELECT price FROM food_items WHERE id = $food_id";
    $res = $conn->query($sql_product);
    if ($res && $res->num_rows > 0) {
        $product = $res->fetch_assoc();
        $price = $product['price'];
    } else {
        die("Product not found");
    }

    // Total price calculation
    $total = $price * $quantity;

    // Insert into orders table (total_price)
    $sql_order = "INSERT INTO orders (user_id, total_price, status) VALUES ($user_id, $total, 'pending')";
    if ($conn->query($sql_order)) {
        $order_id = $conn->insert_id;

        // Insert into order_items table (food_id)
        $sql_item = "INSERT INTO order_items (order_id, food_id, quantity, price) 
                     VALUES ($order_id, $food_id, $quantity, $price)";
        if ($conn->query($sql_item)) {
            $msg = "Order placed successfully!";
        } else {
            $msg = "Error inserting order item: " . $conn->error;
        }
    } else {
        $msg = "Error placing order: " . $conn->error;
    }

} else {
    $msg = "Invalid request";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Place Order</title>
    <style>
        body { font-family: Arial; padding:20px; }
        .msg { background:#d4edda; padding:10px; border-radius:5px; color:#155724; }
        a { display:inline-block; margin-top:10px; text-decoration:none; color:#007bff; }
    </style>
</head>
<body>

<h2>Place Order</h2>

<p class="msg"><?php echo $msg; ?></p>
<a href="customer_products.php">Back to Products</a>

</body>
</html>