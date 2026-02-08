<?php
session_start();
include "config/db.php";

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            // Login successful
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            // Redirect based on role
            if ($row['role'] === 'admin') {
                header("Location: admin_orders.php"); // Admin page
                exit;
            } else {
                header("Location: customer_products.php"); // Customer page
                exit;
            }
        } else {
            $error = "Incorrect password";
        }
    } else {
        $error = "Email not found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body { font-family: Arial; padding:20px; background:#f7f7f7; }
        form { max-width:300px; margin:auto; background:#fff; padding:20px; border-radius:5px; box-shadow:0 2px 5px rgba(0,0,0,.1); }
        input { width:100%; padding:8px; margin-bottom:10px; }
        button { width:100%; padding:8px; background:#007bff; color:#fff; border:none; cursor:pointer; }
        .error { color:red; margin-bottom:10px; }
    </style>
</head>
<body>

<h2 style="text-align:center;">Login</h2>

<form method="post">
    <?php if (isset($error)) echo "<p class='error'>{$error}</p>"; ?>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="login">Login</button>
</form>

</body>
</html>