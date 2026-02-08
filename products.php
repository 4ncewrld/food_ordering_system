<?php
session_start();
include "config/db.php";

/* Only admin access */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

/* Handle search */
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$sql_products = "SELECT * FROM products WHERE name LIKE '%$search%' ORDER BY id DESC";
$result_products = $conn->query($sql_products);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Products Management</title>
    <style>
        body { font-family: Arial; padding:20px; background:#f7f7f7; }
        table { width:100%; border-collapse: collapse; margin-top:20px; }
        th, td { padding:10px; border:1px solid #ccc; text-align:left; }
        th { background:#007bff; color:#fff; }
        a.button { padding:4px 8px; background:#007bff; color:#fff; text-decoration:none; border-radius:3px; margin-right:5px; }
        a.button.delete { background:red; }
        form.search { margin-bottom:20px; }
        input[type=text] { padding:5px; margin-right:5px; }
        button { padding:5px 10px; }
    </style>
</head>
<body>

<h2>Products Management</h2>

<a href="add.php" class="button">Add New Product</a>

<!-- Search Form -->
<form method="get" class="search">
    <input type="text" name="search" placeholder="Search by Product Name" value="<?php echo htmlspecialchars($search); ?>">
    <button type="submit">Search</button>
</form>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Price</th>
        <th>Actions</th>
    </tr>
    <?php
    if ($result_products && $result_products->num_rows > 0) {
        while ($product = $result_products->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$product['id']}</td>";
            echo "<td>{$product['name']}</td>";
            echo "<td>Tsh {$product['price']}</td>";
            echo "<td>
                    <a href='edit.php?id={$product['id']}' class='button'>Edit</a>
                    <a href='delete.php?id={$product['id']}' class='button delete' onclick=\"return confirm('Are you sure you want to delete this product?');\">Delete</a>
                  </td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No products found.</td></tr>";
    }
    ?>
</table>

<a href="admin_orders.php">Go to Orders Management</a>

</body>
</html>