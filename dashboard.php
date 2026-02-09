<?php
session_start();
include "config/db.php";

/* Only admin access */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

/* Fetch counts */
$total_products = $conn->query("SELECT COUNT(*) as count FROM products")->fetch_assoc()['count'];
$total_orders   = $conn->query("SELECT COUNT(*) as count FROM orders")->fetch_assoc()['count'];
$total_customers= $conn->query("SELECT COUNT(*) as count FROM users WHERE role='customer'")->fetch_assoc()['count'];

/* Fetch recent orders - based on your table schema */
$recent_orders = $conn->query("
    SELECT o.id, u.username, o.total_price, o.status, o.created_at
    FROM orders o
    JOIN users u ON o.user_id = u.id
    ORDER BY o.created_at DESC
    LIMIT 5
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<style>
    body { font-family: Arial; background:#f7f7f7; margin:0; padding:0; }
    header { background:#007bff; color:#fff; padding:15px; text-align:center; }
    nav { background:#343a40; color:#fff; padding:10px; display:flex; justify-content:center; gap:15px; }
    nav a { color:#fff; text-decoration:none; font-weight:bold; }
    .container { padding:20px; max-width:1200px; margin:auto; }
    .stats { display:flex; gap:20px; flex-wrap:wrap; margin-bottom:20px; }
    .card { background:#fff; padding:20px; flex:1; min-width:200px; border-radius:5px; box-shadow:0 2px 5px rgba(0,0,0,.1); text-align:center; }
    .card h3 { margin:0; font-size:24px; color:#007bff; }
    .card p { margin:5px 0 0 0; font-size:16px; color:#333; }
    table { width:100%; border-collapse:collapse; background:#fff; border-radius:5px; overflow:hidden; box-shadow:0 2px 5px rgba(0,0,0,.1); }
    table th, table td { padding:10px; text-align:left; border-bottom:1px solid #ddd; }
    table th { background:#007bff; color:#fff; }
    h2 { margin-top:0; }
    .quick-links { display:flex; gap:15px; flex-wrap:wrap; margin-bottom:20px; }
    .quick-links a { text-decoration:none; background:#28a745; color:#fff; padding:10px 15px; border-radius:5px; font-weight:bold; }
    .quick-links a:hover { background:#218838; }
</style>
</head>
<body>

<header>
    <h1>4nce Food Ordering System</h1>
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></p>
</header>

<nav>
    <a href="dashboard.php">Dashboard</a>
    <a href="add.php">Add Product</a>
    <a href="products.php">Manage Products</a>
    <a href="admin_orders.php">Orders Management</a>
    <a href="logout.php">Logout</a>
</nav>

<div class="container">

    <div class="stats">
        <div class="card">
            <h3><?php echo $total_products; ?></h3>
            <p>Total Products</p>
        </div>
        <div class="card">
            <h3><?php echo $total_orders; ?></h3>
            <p>Total Orders</p>
        </div>
        <div class="card">
            <h3><?php echo $total_customers; ?></h3>
            <p>Total Customers</p>
        </div>
    </div>

    <div class="quick-links">
        <a href="add.php">Add Product</a>
        <a href="products.php">Manage Products</a>
        <a href="admin_orders.php">View Orders</a>
    </div>

    <h2>Recent Orders</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Total Price</th>
            <th>Status</th>
            <th>Ordered At</th>
        </tr>
        <?php if ($recent_orders && $recent_orders->num_rows > 0): ?>
            <?php while($row = $recent_orders->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td>TZS <?php echo number_format($row['total_price']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5" style="text-align:center;">No orders yet</td></tr>
        <?php endif; ?>
    </table>

</div>

</body>
</html>