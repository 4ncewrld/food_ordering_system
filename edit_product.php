<?php
include "config/db.php";
session_start();

// Only admin can edit products
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    echo "<h3>Access denied. Only admin can edit products.</h3>";
    exit();
}

// Get product ID from URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch existing product
    $sql = "SELECT * FROM food_items WHERE id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "Product not found";
        exit();
    }
} else {
    echo "No product ID provided";
    exit();
}

// Handle form submission
if (isset($_POST['update_product'])) {
    $name = trim($_POST['name']);
    $price = trim($_POST['price']);

    if ($name != "" && $price != "") {
        $update = "UPDATE food_items SET name='$name', price='$price' WHERE id=$id";
        if ($conn->query($update)) {
            $msg = "Product updated successfully!";
            // Refresh product data
            $result = $conn->query("SELECT * FROM food_items WHERE id = $id");
            $product = $result->fetch_assoc();
        } else {
            $msg = "Error: " . $conn->error;
        }
    } else {
        $msg = "Please fill all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<h2>Edit Product (Admin Only)</h2>

<?php
if (isset($msg)) {
    echo "<p style='color:green;'>$msg</p>";
}
?>

<form method="post">
    <input type="text" name="name" value="<?php echo $product['name']; ?>" required><br><br>
    <input type="number" name="price" value="<?php echo $product['price']; ?>" required><br><br>
    <button type="submit" name="update_product">Update Product</button>
</form>

</body>
</html>