<?php
// 1. Zuia session isijirudie ili kuzuia ile "Notice" ya orange
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "config/db.php";

/* 2. Only admin access */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

/* 3. Handle confirm/cancel actions (Updated with Security) */
if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $action = $_POST['update_status']; 

    if($action === 'confirm') {
        $new_status = 'paid';
    } elseif($action === 'cancel') {
        $new_status = 'cancelled';
    } else {
        $new_status = '';
    }

    if($new_status != ''){
        // Tunatumia Prepared Statement hapa kwa usalama zaidi
        $stmt = $conn->prepare("UPDATE orders SET status=? WHERE id=?");
        $stmt->bind_param("si", $new_status, $order_id);
        $stmt->execute();
        $stmt->close();
    }
}

/* 4. Handle search/filter */
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';

/* 5. Fetch orders (Join ili kupata jina la mteja) */
$query = "SELECT o.*, u.username 
          FROM orders o
          JOIN users u ON o.user_id = u.id
          WHERE (o.id LIKE ? OR u.username LIKE ?)";

if ($status_filter != '') {
    $query .= " AND o.status = '$status_filter'";
}

$query .= " ORDER BY o.created_at DESC";

$stmt = $conn->prepare($query);
$search_param = "%$search%";
$stmt->bind_param("ss", $search_param, $search_param);
$stmt->execute();
$result_orders = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Orders Management</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding:20px; background:#f4f7f6; color: #333; }
        .container { max-width: 1100px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h2 { color: #007bff; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
        table { width:100%; border-collapse: collapse; margin-top:20px; }
        th, td { padding:12px; border:1px solid #eee; text-align:left; }
        th { background:#007bff; color:#fff; }
        tr:hover { background: #f9f9f9; }
        button { padding:6px 12px; border:none; border-radius:4px; cursor:pointer; font-weight: bold; }
        .confirm { background:#28a745; color:#fff; }
        .confirm:hover { background:#218838; }
        .cancel { background:#dc3545; color:#fff; }
        .cancel:hover { background:#c82333; }
        form.filter { margin-bottom:20px; display: flex; gap: 10px; }
        input[type=text], select { padding:8px; border: 1px solid #ccc; border-radius: 4px; }
        .badge { padding: 4px 8px; border-radius: 12px; font-size: 12px; }
        .nav-link { display: inline-block; margin-top: 20px; text-decoration: none; color: #007bff; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <h2>Order Management Dashboard</h2>

    <form method="get" class="filter">
        <input type="text" name="search" placeholder="Order ID or Customer..." value="<?php echo htmlspecialchars($search); ?>">
        <select name="status">
            <option value="">-- All Status --</option>
            <option value="pending" <?php if($status_filter=='pending') echo 'selected'; ?>>Pending</option>
            <option value="paid" <?php if($status_filter=='paid') echo 'selected'; ?>>Paid</option>
            <option value="cancelled" <?php if($status_filter=='cancelled') echo 'selected'; ?>>Cancelled</option>
        </select>
        <button type="submit" style="background: #007bff; color: white;">Apply Filter</button>
    </form>

    <?php if ($result_orders && $result_orders->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Total (TZS)</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = $result_orders->fetch_assoc()): ?>
                    <tr>
                        <td>#<?php echo $order['id']; ?></td>
                        <td><strong><?php echo htmlspecialchars($order['username']); ?></strong></td>
                        <td><?php echo number_format($order['total_price'], 2); ?></td>
                        <td>
                            <?php 
                                $status = $order['status'];
                                $color = ($status == 'paid') ? '#28a745' : (($status == 'cancelled') ? '#dc3545' : '#6c757d');
                                echo "<span class='badge' style='background: $color; color: white;'>" . ucfirst($status) . "</span>";
                            ?>
                        </td>
                        <td><?php echo date('M d, Y H:i', strtotime($order['created_at'])); ?></td>
                        <td>
                            <?php if ($order['status'] === 'pending'): ?>
                                <form method='post' style='display:inline;'>
                                    <input type='hidden' name='order_id' value='<?php echo $order['id']; ?>'>
                                    <button type='submit' name='update_status' value='confirm' class='confirm'>Confirm</button>
                                    <button type='submit' name='update_status' value='cancel' class='cancel'>Cancel</button>
                                </form>
                            <?php else: ?>
                                <span style="color: #999;">No action</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="padding: 20px; background: #fff3cd; color: #856404; border-radius: 4px;">No orders found matching your criteria.</p>
    <?php endif; ?>

    <a href="dashboard.php" class="nav-link">← Back to Dashboard</a>
</div>

</body>
</html>