<?php
include "config/db.php";

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = "customer";

    $check = $conn->query("SELECT id FROM users WHERE email='$email'");
    if ($check->num_rows > 0) {
        echo "Email already exists";
    } else {
        $conn->query("INSERT INTO users (username, email, password, role)
                      VALUES ('$username', '$email', '$password', '$role')");
        echo "Registration successful";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="assets/style.css">
</head>
<body>

<h2>User Registration</h2>

<form method="post">
    <input type="text" name="username" placeholder="Username" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit" name="register">Register</button>
</form>

</body>
</html>