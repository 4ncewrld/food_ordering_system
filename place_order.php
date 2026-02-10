<?php
include "config/db.php";

// 1. Zuia session notice
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "navbar.php";

/* 2. Hakikisha user amelogin */
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer'){
    header("Location: login.php");
    exit;
}

/* 3. Hakikisha cart si empty */
if(!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0){
    header("Location: customer_products.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* 4. Calculate total price */
$total_price = 0;
foreach($_SESSION['cart'] as $item){
    $total_price += $item['price'] * $item['qty'];
}

/* 5. Handle place order submission */
if(isset($_POST['place_order'])){
    // Tumia Prepared Statements kwa usalama
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_price, status) VALUES (?, ?, 'pending')");
    $stmt->bind_param("id", $user_id, $total_price);
    
    if($stmt->execute()){
        // Clear cart baada ya kufanikiwa
        unset($_SESSION['cart']);

        // Success Page UI
        echo "
        <div style='max-width:600px; margin:100px auto; text-align:center; font-family:Arial; background:white; padding:40px; border-radius:10px; box-shadow:0 4px 15px rgba(0,0,0,0.1);'>
            <h2 style='color:#ff5722;'>Welcome to 4nce Food Ordering System!</h2>
            <div style='font-size:50px; margin:20px 0;'>✅</div>
            <p style='color:#28a745; font-size:18px; font-weight:bold;'>Your order has been placed successfully.</p>
            <p style='color:#666;'>Enjoy your meal! Karibu tena 😊</p>
            <br>
            <a href='customer_products.php' style='text-decoration:none; background:#007bff; color:white; padding:10px 20px; border-radius:5px;'>Back to Menu</a>
        </div>";
        exit;
    } else {
        echo "<div style='color:red; text-align:center;'>Error: " . $conn->error . "</div>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order - 4nce Food Ordering System</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background:#f8f9fa; margin:0; padding:0; }
        .container { max-width:700px; margin:50px auto; background:white; padding:30px; border-radius:12px; box-shadow:0 10px 25px rgba(0,0,0,0.1); }
        h2 { color:#ff5722; text-align:center; border-bottom: 2px solid #ff5722; padding-bottom: 15px; }
        table { width:100%; border-collapse:collapse; margin:25px 0; }
        th, td { padding:15px; border-bottom:1px solid #eee; text-align:left; }
        th { background:#fdf2f0; color:#ff5722; font-weight: bold; }
        .total-row { background:#f8f9fa; font-size: 18px; }
        .total-price { font-weight:bold; color:#007bff; text-align: right; }
        .btn-confirm { display:block; width:100%; padding:15px; background:#007bff; color:white; border:none; border-radius:8px; cursor:pointer; font-size:18px; font-weight:bold; transition: 0.3s; }
        .btn-confirm:hover { background:#0056b3; transform: translateY(-2px); }
    </style>
</head>
<body>

<div class="container">
    <h2>Your Order Summary</h2>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Qty</th>
                <th style="text-align:right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($_SESSION['cart'] as $item): 
                $subtotal = $item['price'] * $item['qty']; ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td><?php echo number_format($item['price']); ?></td>
                    <td><?php echo $item['qty']; ?></td>
                    <td style="text-align:right;"><?php echo number_format($subtotal); ?> TZS</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="3" style="font-weight:bold;">Total Amount</td>
                <td class="total-price"><?php echo number_format($total_price); ?> TZS</td>
            </tr>
        </tfoot>
    </table>

    <form method="POST">
        <button type="submit" name="place_order" class="btn-confirm">Confirm & Place Order Now</button>
    </form>
</div>

</body>
</html>