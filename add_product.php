<?php
include "config/db.php";

if (isset($_POST['add_product'])) {
    $name = trim($_POST['name']);
    $price = trim($_POST['price']);

    // Simple validation
    if ($name != "" && $price != "") {
        $sql = "INSERT INTO food_items (name, price) VALUES ('$name', '$price')";
        if ($conn->query($sql)) {
            $msg = "Product added successfully!";
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
    <title>Add Product</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<h2>Add New Product</h2>

<?php
if (isset($msg)) {
    echo "<p style='color:green;'>$msg</p>";
}
?>

<form method="post">
    <input type="text" name="name" placeholder="Product Name" required><br><br>
    <input type="number" name="price" placeholder="Price" required><br><br>
    <button type="submit" name="add_product">Add Product</button>
</form>

</body>
</html>