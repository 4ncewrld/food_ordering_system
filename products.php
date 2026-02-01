<?php
include "config/db.php";

$sql = "SELECT * FROM food_items";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "Product ID: " . $row["id"] . " - Name: " . $row["name"] . " - Price: Tsh " . number_format($row["price"], 0) . "<br>";
    }
} else {
    echo "No products found.";
}
?>