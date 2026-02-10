<?php
session_start();
include "config/db.php";

/* Hakikisha customer amelogin */
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer'){
    header("Location: login.php");
    exit;
}

/* Pata product id */
if(!isset($_GET['id'])){
    header("Location: customer_products.php");
    exit;
}

$product_id = (int)$_GET['id'];

/* Chukua product kutoka DB */
$sql = "SELECT id, name, price FROM products WHERE id = $product_id";
$result = $conn->query($sql);

if(!$result || $result->num_rows == 0){
    die("Product not found");
}

$product = $result->fetch_assoc();

/* Initialize cart kama haipo */
if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
}

/* Kama product tayari ipo cart, ongeza qty */
if(isset($_SESSION['cart'][$product_id])){
    $_SESSION['cart'][$product_id]['qty'] += 1;
} 
/* Kama haipo, iongeze mpya */
else {
    $_SESSION['cart'][$product_id] = [
        'name'  => $product['name'],
        'price' => $product['price'],
        'qty'   => 1
    ];
}

/* Rudi kwenye cart */
header("Location: cart.php");
exit;