<?php
include "config/db.php";

$sql = "SELECT customer, review, created_at 
        FROM feedback 
        ORDER BY created_at DESC 
        LIMIT 5";

$result = $conn->query($sql);

$feedbacks = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $feedbacks[] = $row;
    }
}

header("Content-Type: application/json");
echo json_encode($feedbacks);