<?php
include "config/db.php";
session_start();

// Ensure user is logged in as customer
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer'){
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>4nce Food Ordering System - Products</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background:#f4f4f4;
            margin:0;
            padding:0;
        }
        h1, h2 {
            text-align:center;
            margin:20px 0;
            color:#ff5722;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            padding: 20px;
            max-width: 1100px;
            margin:auto;
        }

        .product-card {
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.15);
            transition: transform 0.2s;
        }
        .product-card:hover {
            transform: scale(1.03);
        }

        .product-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .product-card h3 {
            font-size: 18px;
            margin: 5px 0;
            color:#333;
        }

        .product-card p {
            margin: 5px 0;
            font-weight: bold;
            color:#007bff;
        }

        .product-card .btn {
            margin-top: 10px;
            display:inline-block;
            padding:10px 18px;
            background:#007bff;
            color:#fff;
            text-decoration:none;
            border-radius:5px;
            transition: background 0.2s;
        }

        .product-card .btn:hover {
            background:#0056b3;
        }
    </style>
</head>
<body>

<h1>4nce Food Ordering System</h1>
<h2>Our Foods</h2>

<div class="products-grid">
    <?php
    // Fetch all products from DB
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // Use offline image path
            $image_path = "assets/images/" . $row['image'];

            // Check if image exists
            if(!file_exists($image_path)){
                $image_path = "assets/images/default.png"; // optional fallback
            }
    ?>
        <div class="product-card">
            <img src="<?php echo $image_path; ?>" alt="<?php echo $row['name']; ?>">
            <h3><?php echo $row['name']; ?></h3>
            <p>Price: TZS <?php echo number_format($row['price'], 2); ?></p>
            <a href="place_order.php?product_id=<?php echo $row['id']; ?>" class="btn">Order Now</a>
        </div>
    <?php
        }
    } else {
        echo "<p style='text-align:center;'>No products found.</p>";
    }
    ?>
</div>

</body>
</html>