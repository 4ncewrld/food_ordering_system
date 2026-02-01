<?php
include "config/db.php";
include "config/auth.php"; // protect page
requireRole('admin');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Orders</title>
    <link rel="stylesheet" type="text/css" href="assets/style.css">
</head>
<body>

<h2>All Orders</h2>

<?php
$sql = "SELECT * FROM orders";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='8'>
            <tr>
                <th>Order ID</th>
                <th>User ID</th>
                <th>Total (TZS)</th>
                <th>Status</th>
                <th>Date</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['user_id']}</td>
                <td>" . number_format($row['total_price'], 0) . "</td>
                <td>{$row['status']}</td>
                <td>{$row['created_at']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No orders found";
}
?>

</body>
</html>