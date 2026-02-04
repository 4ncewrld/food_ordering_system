<?php
session_start();
include "config/db.php";

/* Only logged-in customers */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.php");
    exit;
}

if (isset($_POST['cancel_order'])) {
    $order_id = $_POST['order_id'];
    $user_id = $_SESSION['user_id'];

    // Make sure this order belongs to this customer and is pending
    $sql_check = "SELECT * FROM orders WHERE id=$order_id AND user_id=$user_id AND status='pending'";
    $res_check = $conn->query($sql_check);

    if ($res_check && $res_check->num_rows > 0) {
        // Update status to cancelled
        $sql_update = "UPDATE orders SET status='cancelled' WHERE id=$order_id";
        if ($conn->query($sql_update)) {
            $msg = "Order cancelled successfully!";
        } else {
            $msg = "Error cancelling order: " . $conn->error;
        }
    } else {
        $msg = "Order cannot be cancelled.";
    }
} else {
    $msg = "Invalid request.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cancel Order</title>
    <style>
        body { font-family: Arial; padding:20px; }
        .msg { background:#f8d7da; padding:10px; border-radius:5px; color:#721c24; }
        a { display:inline-block; margin-top:10px; text-decoration:none; color:#007bff; }
    </style>
</head>
<body>

<h2>Cancel Order</h2>

<p class="msg"><?php echo $msg; ?></p>
<a href="customer_orders.php">Back to Orders</a>

</body>
</html>