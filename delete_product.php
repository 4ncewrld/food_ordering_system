<?php
include "config/db.php";
session_start();

// Only admin can delete products
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    echo "<h3>Access denied. Only admin can delete products.</h3>";
    exit();
}

// Check if product ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete product
    $delete = "DELETE FROM food_items WHERE id = $id";
    if ($conn->query($delete)) {
        echo "<p>Product deleted successfully!</p>";
        echo '<p><a href="products.php">Go back to products list</a></p>';
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "No product ID provided";
}
?>