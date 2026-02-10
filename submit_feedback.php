<?php
include "config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input
    $customer = trim($_POST['customer']);
    $email    = trim($_POST['email']);
    $contact  = trim($_POST['contact']);
    $review   = trim($_POST['review']);

    // Check if any field is empty
    if (empty($customer) || empty($email) || empty($contact) || empty($review)) {
        header("Location: feedback.php?status=empty");
        exit;
    }

    // Insert into database using Prepared Statements
    $stmt = $conn->prepare("INSERT INTO feedback (customer, email, contact, review) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $customer, $email, $contact, $review);

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: feedback.php?status=success");
        exit;
    } else {
        die("Error: " . $conn->error);
    }
} else {
    header("Location: feedback.php");
    exit;
}
?>