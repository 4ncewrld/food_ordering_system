<?php
include "config/db.php";

// Fetch all feedbacks from database, newest first
$sql = "SELECT * FROM feedback ORDER BY created_at DESC";
$result = $conn->query($sql);

$feedbacks = [];

if($result && $result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $feedbacks[] = [
            'customer' => $row['customer'],
            'email'    => $row['email'],
            'contact'  => $row['contact'],
            'review'   => $row['review'],
            'created_at' => $row['created_at']
        ];
    }
}

// Return JSON
header('Content-Type: application/json');
echo json_encode($feedbacks);