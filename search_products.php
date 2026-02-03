<?php
include "config/db.php";

$query = "";
if (isset($_GET['q'])) {
    $query = $_GET['q'];
}

// Safe query to prevent SQL injection
$query = $conn->real_escape_string($query);

// Fetch products matching search
$sql = "SELECT * FROM food_items WHERE name LIKE '%$query%'";
$result = $conn->query($sql);

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