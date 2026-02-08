<?php
include "config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $message = trim($_POST['message']);

    if ($name != "" && $message != "") {
        $stmt = $conn->prepare("INSERT INTO feedback (customer_name, message) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $message);
        $stmt->execute();
        $stmt->close();

        header("Location: index.php?feedback=success");
        exit;
    }
}

header("Location: index.php?feedback=error");
exit;