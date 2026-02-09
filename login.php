<?php
// Onyesha errors (hakika haionekani blank)
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "config/db.php"; // Ensure db.php exists kwenye config folder

// Handle login form submit
if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Handle both hashed (admin) and plain password (customer1)
        if (password_verify($password, $row['password']) || $password == $row['password']) {
            
            // Set session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            // Redirect based on role
            if ($row['role'] == 'admin') {
                header("Location: admin_orders.php");
            } else {
                header("Location: customer_products.php");
            }
            exit;
        } else {
            $error = "Incorrect password!";
        }

    } else {
        $error = "Email not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>4nce Food Ordering System - Login</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        .login-container {
            max-width: 400px;
            margin: 80px auto;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #f7f7f7;
        }
        .login-container h2 { text-align: center; margin-bottom: 20px; }
        .login-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }
        .login-container button {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        .error { color: red; text-align: center; }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login</h2>

    <?php if(isset($error)) { echo "<p class='error'>$error</p>"; } ?>

    <form method="POST" action="">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
    </form>
</div>

</body>
</html>