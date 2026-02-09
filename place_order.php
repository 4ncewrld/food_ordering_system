<?php
include "config/db.php";
session_start();

// Ensure user is logged in
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

// Check if product_id is provided
if(!isset($_GET['product_id'])){
    die("Invalid Request: Product not selected.");
}

$product_id = intval($_GET['product_id']);
$user_id = $_SESSION['user_id'];

// Fetch product info
$sql = "SELECT * FROM products WHERE id=$product_id";
$result = $conn->query($sql);

if($result && $result->num_rows == 1){
    $product = $result->fetch_assoc();
} else {
    die("Product not found.");
}

// Handle form submission
if(isset($_POST['place_order'])){
    $quantity = intval($_POST['quantity']);
    if($quantity <= 0){
        $error = "Quantity must be at least 1.";
    } else {
        $price = $product['price'];
        $total = $price * $quantity;

        $insert = "INSERT INTO orders (user_id, product_id, quantity, total_price, status, created_at)
                   VALUES ($user_id, $product_id, $quantity, $total, 'Pending', NOW())";
        if($conn->query($insert)){
            $success = "Order placed successfully!";
        } else {
            $error = "Failed to place order.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Place Order - <?php echo $product['name']; ?></title>
</head>
<body>
<h2>Place Order: <?php echo $product['name']; ?></h2>

<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<?php if(isset($success)) echo "<p style='color:green;'>$success</p>"; ?>

<form method="post">
    <p>Price: TZS <?php echo number_format($product['price'],2); ?></p>
    <label>Quantity:</label>
    <input type="number" name="quantity" value="1" min="1" required>
    <button type="submit" name="place_order">Place Order</button>
</form>

<p><a href="customer_products.php">Back to Products</a></p>
</body>
</html>