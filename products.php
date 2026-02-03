<?php
// 1. DB connection
include "config/db.php";

// 2. Fetch all products
$sql = "SELECT * FROM food_items";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Food Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        input {
            padding: 8px;
            width: 250px;
            margin-bottom: 15px;
        }
        .product {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
            width: 400px;
        }
    </style>
</head>
<body>

<h2>Food Products</h2>

<!-- SEARCH BOX (AJAX READY) -->
<input 
    type="text" 
    id="searchInput" 
    placeholder="Search product..."
>

<!-- PRODUCTS LIST -->
<div id="products">
    <script>
const searchInput = document.getElementById('searchInput');
const productsDiv = document.getElementById('products');

searchInput.addEventListener('input', () => {
    const query = searchInput.value;

    fetch('search_products.php?q=' + encodeURIComponent(query))
        .then(response => response.text())
        .then(data => {
            productsDiv.innerHTML = data;
        })
        .catch(error => console.error('Error:', error));
});
</script>
<?php
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="product">';
        echo 'Product ID: ' . $row["id"] . '<br>';
        echo 'Name: ' . $row["name"] . '<br>';
        echo 'Price: Tsh ' . $row["price"];
        echo '</div>';
    }
} else {
    echo "No products found.";
}
?>
</div>

</body>
</html>