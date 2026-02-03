<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Optional: Only admin can access admin pages
if ($_SESSION['role'] != 'admin') {
    echo "<h3>Access denied. You are not an admin.</h3>";
    exit();
}

// Continue with dashboard content
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>

<p>This is the admin dashboard.</p>

<!-- Add your dashboard content here -->

</body>
</html>