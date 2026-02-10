<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<style>
/* ===== NAVBAR ===== */
.navbar {
    background: linear-gradient(to right,#ff7a18,#ffb347);
    padding:15px 30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    font-family:Arial, sans-serif;
}

.navbar .logo {
    font-size:24px;
    font-weight:bold;
    color:white;
}

.navbar .logo span:nth-child(1){color:#00ffd5;}
.navbar .logo span:nth-child(2){color:#ffff00;}
.navbar .logo span:nth-child(3){color:#ffffff;}

.navbar .nav-links a {
    color:white;
    text-decoration:none;
    margin-left:20px;
    font-weight:bold;
}

.navbar .nav-links a:hover{
    text-decoration:underline;
}

.navbar .nav-links {
    display:flex;
    align-items:center;
}
</style>

<div class="navbar">
    <div class="logo">
        <span>4nce</span> <span>Food Ordering</span> <span>System</span>
    </div>
    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="about.php">About Us</a>
        <a href="privacy.php">Privacy Policy</a>
        <a href="terms.php">Terms</a>
        <a href="feedback.php">Feedback</a>
        <a href="logout.php">Logout</a>
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="customer_products.php">Menu</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </div>
</div>