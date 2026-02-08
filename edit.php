<?php
session_start();
include "config/db.php";

/* Only admin access */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

/* Get product ID from URL */
if (!isset($_GET['id'])) {
    header("Location: products.php");
    exit;
}

$product_id = $_GET['id'];

/* Fetch product details */
$sql = "SELECT * FROM products WHERE id=$product_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "Product not found";
    exit;
}

$product = $result->fetch_assoc();

/* Fetch categories for dropdown */
$cat_sql = "SELECT * FROM categories";
$cat_result = $conn->query($cat_sql);

/* Handle form submission */
if (isset($_POST['update_product'])) {
    $name = trim($_POST['name']);
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];

    $sql_update = "UPDATE products SET name='$name', price='$price', category_id='$category_id' WHERE id=$product_id";

    if ($conn->query($sql_update)) {
        echo "<p style='color:green;'>Product updated successfully</p>";
        /* Refresh product details */
        $result = $conn->query("SELECT * FROM products WHERE id=$product_id");
        $product = $result->fetch_assoc();
    } else {
        echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <style>
        body { font-family: Arial; padding:20px; background:#f7f7f7; }
        form { max-width:400px; margin:auto; background:#fff; padding:20px; border-radius:5px; box-shadow:0 2px 5px rgba(0,0,0,.1); }
        input, select, button { width:100%; padding:8px; margin-bottom:10px; }
        button { background:#007bff; color:#fff; border:none; cursor:pointer; }
    </style>
</head>
<body>

<h2>Edit Product</h2>

<form method="post">
    <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" placeholder="Product Name" required>
    <input type="number" name="price" value="<?php echo $product['price']; ?>" placeholder="Price" required>

    <select name="category_id" required>
        <option value="">--Select Category--</option>
        <?php
        if ($cat_result && $cat_result->num_rows > 0) {
            while ($cat = $cat_result->fetch_assoc()) {
                $selected = ($cat['id'] == $product['category_id']) ? 'selected' : '';
                echo "<option value='{$cat['id']}' $selected>{$cat['name']}</option>";
            }
        }
        ?>
    </select>

    <button type="submit" name="update_product">Update Product</button>
</form>

<a href="products.php">Back to Products</a>

</body>
</html>