<?php
session_start();
include "config/db.php";

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer'){
    header("Location: login.php");
    exit;
}

// initialize cart
if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
}

// remove item
if(isset($_GET['remove'])){
    $remove_id = $_GET['remove'];
    unset($_SESSION['cart'][$remove_id]);
    header("Location: cart.php");
    exit;
}

$total = 0;
?>

<!DOCTYPE html>
<html>
<head>
<title>Your Cart</title>
<style>
body{
    font-family:Arial;
    background:#f4f4f4;
}
.cart-box{
    width:700px;
    margin:60px auto;
    background:white;
    padding:20px;
    border-radius:8px;
}
table{
    width:100%;
    border-collapse:collapse;
}
th,td{
    padding:10px;
    border-bottom:1px solid #ddd;
    text-align:center;
}
th{
    background:#ff5722;
    color:white;
}
.total{
    font-size:18px;
    font-weight:bold;
    text-align:right;
    margin-top:15px;
}
.btn{
    padding:8px 15px;
    background:#007bff;
    color:white;
    text-decoration:none;
    border-radius:5px;
}
.btn-danger{
    background:red;
}
.checkout{
    margin-top:20px;
    text-align:right;
}
</style>
</head>
<body>

<div class="cart-box">
<h2>Your Cart</h2>

<?php if(empty($_SESSION['cart'])): ?>
    <p>Your cart is empty.</p>
<?php else: ?>

<table>
<tr>
    <th>Food</th>
    <th>Price</th>
    <th>Qty</th>
    <th>Subtotal</th>
    <th>Action</th>
</tr>

<?php foreach($_SESSION['cart'] as $id => $item): 
    $subtotal = $item['price'] * $item['qty'];
    $total += $subtotal;
?>
<tr>
    <td><?= $item['name'] ?></td>
    <td>TZS <?= number_format($item['price'],2) ?></td>
    <td><?= $item['qty'] ?></td>
    <td>TZS <?= number_format($subtotal,2) ?></td>
    <td>
        <a class="btn btn-danger" href="cart.php?remove=<?= $id ?>">Remove</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

<p class="total">Total: TZS <?= number_format($total,2) ?></p>

<div class="place order">
    <a class="btn" href="place_order.php">Place Order</a>
</div>

<?php endif; ?>

</div>
</body>
</html>