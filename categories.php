<?php
include "config/db.php";

$sql = "SELECT * FROM categories";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "Category ID: " . $row["id"] . " - Name: " . $row["name"] . "<br>";
    }
} else {
    echo "No categories found.";
}
?>