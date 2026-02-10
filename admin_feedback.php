<?php
include "config/db.php";
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// Access control: Only admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include "navbar.php";
$result = $conn->query("SELECT * FROM feedback ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Customer Reviews</title>
    <style>
        .admin-box { padding: 40px; font-family: 'Segoe UI', sans-serif; }
        table { width: 100%; border-collapse: collapse; background: white; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        th, td { padding: 15px; border: 1px solid #eee; text-align: left; }
        th { background: #ff5722; color: white; }
        tr:hover { background: #fcfcfc; }
        .badge { background: #eee; padding: 5px 10px; border-radius: 5px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="admin-box">
        <h2>Customer Reviews & Feedback</h2>
        <table>
            <tr>
                <th>Date</th>
                <th>Customer</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Review Message</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><span class="badge"><?php echo $row['created_at']; ?></span></td>
                    <td><strong><?php echo htmlspecialchars($row['customer']); ?></strong></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['contact']); ?></td>
                    <td><?php echo nl2br(htmlspecialchars($row['review'])); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>