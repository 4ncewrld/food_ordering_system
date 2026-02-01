<?php
include "config/db.php";

$sql = "SELECT * FROM users LIMIT 1";
$result = $conn->query($sql);

if ($result) {
    echo "Database & table users connected successfully!";
} else {
    die("Error: " . $conn->error);
}
?>