<?php
session_start();
include "config/db.php";

/* Only logged-in customers */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.php");
    exit;
}

// Handle search/filter
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$min_price = isset($_GET['min_price']) ? (float)$_GET['min_price'] : 0;
$max_price = isset($_GET['max_price']) ? (float)$_GET['max_price'] : 100000000; // big number

$sql = "SELECT id, name, price FROM food_items 
        WHERE name LIKE '%$search%' 
        AND price BETWEEN $min_price AND $max_price";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Food Menu</title>
    <style>
        body { font-family: Arial; background:#f7f7f7; padding:20px; }
        .card { background:#fff; padding:15px; margin-bottom:10px; border-radius:5px; box-shadow:0 2px 5px rgba(0,0,0,.1); }
        .price { color:green; font-weight:bold; }
        input[type=number], input[type=text] { padding:3px; margin-right:5px; }
        button { padding:6px 12px; background:#ff9800; border:none; color:#fff; cursor:pointer; border-radius:3px; }
        form.search-form { margin-bottom:20px; }
    </style>
</head>
<body>

<h2>Available Food Products</h2>

<!-- Search & Filter Form -->
<form method="get" class="search-form">
    <input type="text" name="search" placeholder="Search product" value="<?php echo htmlspecialchars($search); ?>">
    Min Price: <input type="number" name="min_price" value="<?php echo $min_price; ?>" min="0">
    Max Price: <input type="number" name="max_price" value="<?php echo $max_price; ?>" min="0">
    <button type="submit">Filter</button>
</form>

<?php
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='card'>";
        echo "<h3>{$row['name']}</h3>";
        echo "<p class='price'>Tsh {$row['price']}</p>";
        echo "<form method='post' action='place_order.php'>";
        echo "<input type='hidden' name='product_id' value='{$row['id']}'>";
        echo "Quantity: <input type='number' name='quantity' value='1' min='1' required>";
        echo "<button type='submit' name='place_order'>Order</button>";
        echo "</form>";
        echo "</div>";
    }
} else {
    echo "<p>No products found.</p>";
}
?>

</body>
</html>