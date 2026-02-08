<?php
session_start();
include "config/db.php";

/* Only admin access */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

/* Handle form submission */
if (isset($_POST['add_product'])) {
    $name = trim($_POST['name']);
    $price = $_POST['price'];
    $category_id = $_POST['category_id']; // must be selected

    $sql = "INSERT INTO products (name, price, category_id) VALUES ('$name', '$price', '$category_id')";

    if ($conn->query($sql)) {
        echo "<p style='color:green;'>Product added successfully</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
    }
}

/* Fetch categories for dropdown */
$cat_sql = "SELECT * FROM categories";
$cat_result = $conn->query($cat_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <style>
        body { font-family: Arial; padding:20px; background:#f7f7f7; }
        form { max-width:400px; margin:auto; background:#fff; padding:20px; border-radius:5px; box-shadow:0 2px 5px rgba(0,0,0,.1); }
        input, select, button { width:100%; padding:8px; margin-bottom:10px; }
        button { background:#007bff; color:#fff; border:none; cursor:pointer; }
    </style>
</head>
<body>

<h2>Add New Product</h2>

<form method="post">
    <input type="text" name="name" placeholder="Product Name" required>
    <input type="number" name="price" placeholder="Price" required>

    <select name="category_id" required>
        <option value="">--Select Category--</option>
        <?php
        if ($cat_result && $cat_result->num_rows > 0) {
            while ($cat = $cat_result->fetch_assoc()) {
                echo "<option value='{$cat['id']}'>{$cat['name']}</option>";
            }
        }
        ?>
    </select>

    <button type="submit" name="add_product">Add Product</button>
</form>

<a href="products.php">Back to Products</a>

</body>
</html>