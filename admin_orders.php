<?php
session_start();
include "config/db.php";

/* Only admin access */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

/* Handle confirm/cancel actions */
if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['status'];

    $sql_update = "UPDATE orders SET status='$new_status' WHERE id=$order_id";
    $conn->query($sql_update);
}

/* Handle search/filter */
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';

/* Fetch orders with search/filter */
$sql_orders = "SELECT o.*, u.username 
               FROM orders o
               JOIN users u ON o.user_id = u.id
               WHERE (o.id LIKE '%$search%' OR u.username LIKE '%$search%')";

if ($status_filter != '') {
    $sql_orders .= " AND o.status='$status_filter'";
}

$sql_orders .= " ORDER BY o.created_at DESC";

$result_orders = $conn->query($sql_orders);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Orders Management</title>
    <style>
        body { font-family: Arial; padding:20px; background:#f7f7f7; }
        table { width:100%; border-collapse: collapse; margin-top:20px; }
        th, td { padding:10px; border:1px solid #ccc; text-align:left; }
        th { background:#007bff; color:#fff; }
        button { padding:4px 8px; margin-right:5px; border:none; border-radius:3px; cursor:pointer; }
        .confirm { background:green; color:#fff; }
        .cancel { background:red; color:#fff; }
        form.filter { margin-bottom:20px; }
        input[type=text], select { padding:5px; margin-right:5px; }
    </style>
</head>
<body>

<h2>All Orders</h2>

<!-- Search / Filter Form -->
<form method="get" class="filter">
    <input type="text" name="search" placeholder="Search by Order ID or Customer" value="<?php echo htmlspecialchars($search); ?>">
    <select name="status">
        <option value="">All Status</option>
        <option value="pending" <?php if($status_filter=='pending') echo 'selected'; ?>>Pending</option>
        <option value="confirmed" <?php if($status_filter=='confirmed') echo 'selected'; ?>>Confirmed</option>
        <option value="cancelled" <?php if($status_filter=='cancelled') echo 'selected'; ?>>Cancelled</option>
    </select>
    <button type="submit">Filter</button>
</form>

<?php
if ($result_orders && $result_orders->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Order ID</th><th>Customer</th><th>Total Price</th><th>Status</th><th>Date</th><th>Action</th></tr>";

    while ($order = $result_orders->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$order['id']}</td>";
        echo "<td>{$order['username']}</td>";
        echo "<td>Tsh {$order['total_price']}</td>";
        echo "<td>{$order['status']}</td>";
        echo "<td>{$order['created_at']}</td>";
        echo "<td>";

        if ($order['status'] === 'pending') {
            echo "<form method='post' style='display:inline-block;'>
                    <input type='hidden' name='order_id' value='{$order['id']}'>
                    <button type='submit' name='update_status' value='confirm' class='confirm'>Confirm</button>
                    <button type='submit' name='update_status' value='cancel' class='cancel'>Cancel</button>
                  </form>";
        } else {
            echo "-";
        }

        echo "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>No orders found.</p>";
}
?>

<a href="products.php">Back to Products Management</a>

</body>
</html>