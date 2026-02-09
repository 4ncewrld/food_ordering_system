<?php
session_start();
include "config/db.php";

/* Only admin access */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$error = "";
$success = "";

/* Handle form submission */
if (isset($_POST['add_product'])) {

    $name = trim($_POST['name']);
    $price = trim($_POST['price']);
    $category_id = $_POST['category_id'];

    /* ===== VALIDATION ===== */
    if ($name === "" || $price === "" || $category_id === "") {
        $error = "All fields are required";
    } elseif (!is_numeric($price)) {
        $error = "Price must be a number";
    } elseif ($price <= 0) {
        $error = "Price must be greater than 0";
    } elseif ($category_id == 0) {
        $error = "Please select a category";
    }

    /* ===== INSERT IF NO ERROR ===== */
    else {
        $stmt = $conn->prepare(
            "INSERT INTO products (name, price, category_id) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("sdi", $name, $price, $category_id);

        if ($stmt->execute()) {
            $success = "Product added successfully";
            // Clear fields after success
            $name = $price = $category_id = "";
        } else {
            $error = "Database error: " . $conn->error;
        }
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
        .error { color:red; margin-bottom:10px; }
        .success { color:green; margin-bottom:10px; }
    </style>
</head>
<body>

<h2 style="text-align:center;">Add New Product</h2>

<form method="post">

    <?php if ($error): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="success"><?php echo $success; ?></div>
    <?php endif; ?>

    <input type="text" name="name" placeholder="Product Name" value="<?php echo htmlspecialchars($name ?? '') ?>">

    <input type="number" name="price" placeholder="Price" value="<?php echo htmlspecialchars($price ?? '') ?>">

    <select name="category_id">
        <option value="">-- Select Category --</option>
        <?php
        if ($cat_result && $cat_result->num_rows > 0) {
            while ($cat = $cat_result->fetch_assoc()) {
                $selected = ($category_id ?? '') == $cat['id'] ? "selected" : "";
                echo "<option value='{$cat['id']}' $selected>{$cat['name']}</option>";
            }
        }
        ?>
    </select>

    <button type="submit" name="add_product">Add Product</button>
</form>

<p style="text-align:center;">
    <a href="products.php">Back to Products</a>
</p>

</body>
</html>