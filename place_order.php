<?php
include "config/auth.php";
include "config/db.php";

if (isset($_POST['submit'])) {
    $food_id = $_POST['food_id'];
    $quantity = $_POST['quantity'];
    $user_id = 1;
    $status = 'pending';

    $food = $conn->query("SELECT price FROM food_items WHERE id = $food_id")->fetch_assoc();
    $total_price = $food['price'] * $quantity;

    $conn->query("INSERT INTO orders (user_id, total_price, status) 
                  VALUES ($user_id, $total_price, '$status')");

    $order_id = $conn->insert_id;

    $conn->query("INSERT INTO order_items (order_id, food_id, quantity, price)
                  VALUES ($order_id, $food_id, $quantity, {$food['price']})");

    echo "Order placed successfully!";
}

$foods = $conn->query("SELECT * FROM food_items");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Place Order</title>
    <link rel="stylesheet" type="text/css" href="assets/style.css">
</head>
<body>

<h2>Place Order</h2>

<form method="post">
    <select name="food_id" required>
        <?php while ($f = $foods->fetch_assoc()) { ?>
            <option value="<?= $f['id'] ?>">
                <?= $f['name'] ?> - Tsh <?= number_format($f['price'], 0) ?>
            </option>
        <?php } ?>
    </select>
    <br><br>

    <input type="number" name="quantity" min="1" required>
    <br><br>

    <button type="submit" name="submit">Order</button>
</form>
<script>
document.querySelector('form').addEventListener('submit', function(e) {
    var qty = document.querySelector('input[name="quantity"]').value;
    if (qty <= 0) {
        alert('Quantity must be at least 1');
        e.preventDefault(); 
    }

    var food = document.querySelector('select[name="food_id"]').value;
    if (food == "") {
        alert('Please select a food item');
        e.preventDefault();
    }
});
</script>
</body>
</html>