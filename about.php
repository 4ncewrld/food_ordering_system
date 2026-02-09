<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>About Us | 4nce Food Ordering System</title>

<style>
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: linear-gradient(to right, #1c1c1c, #2e2e2e);
        color: #fff;
    }

    /* TOP BAR */
    .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 40px;
        background: #000;
    }

    .logo {
        font-size: 24px;
        font-weight: bold;
    }

    .logo span:nth-child(1){ color:#00ffcc; }
    .logo span:nth-child(2){ color:#ffff00; }
    .logo span:nth-child(3){ color:#ffffff; }

    .nav a {
        color: #fff;
        text-decoration: none;
        margin-left: 20px;
        font-weight: bold;
    }

    .nav a:hover {
        text-decoration: underline;
    }

    /* CONTENT */
    .container {
        max-width: 1100px;
        margin: auto;
        padding: 50px 20px;
    }

    .title {
        text-align: center;
        font-size: 36px;
        margin-bottom: 40px;
        color: #ff8c00;
    }

    .section {
        background: rgba(255,255,255,0.05);
        padding: 30px;
        border-radius: 8px;
        margin-bottom: 30px;
    }

    .section h2 {
        margin-bottom: 15px;
        font-size: 26px;
    }

    .story h2 { color: #00ffcc; }
    .system h2 { color: #ffff00; }
    .success h2 { color: #ff7f50; }
    .delivery h2 { color: #00ff7f; }

    .section p {
        line-height: 1.7;
        font-size: 16px;
        color: #ddd;
    }
</style>
</head>
<body>

<!-- TOP BAR -->
<div class="top-bar">
    <div class="logo">
        <span>4nce</span>
        <span>Food Ordering</span>
        <span>System</span>
    </div>

    <div class="nav">
        <a href="index.php">Home</a>
        <a href="about.php">About Us</a>
        <a href="privacy.php">Privacy Policy</a>
        <a href="terms.php">Terms</a>
    </div>
</div>

<!-- CONTENT -->
<div class="container">

    <div class="title">About 4nce</div>

    <div class="section story">
        <h2>Our Story</h2>
        <p>
            4nce Food Ordering System was created to simplify how people order food.
            The idea was born from the need to reduce long waiting times, manual ordering errors,
            and improve customer experience using modern technology.
        </p>
    </div>

    <div class="section system">
        <h2>Our System</h2>
        <p>
            The system allows customers to view food items, place orders online,
            and track their requests easily. Admins can manage products, orders,
            and customers from a central dashboard efficiently.
        </p>
    </div>

    <div class="section success">
        <h2>Our Achievements</h2>
        <p>
            4nce has successfully demonstrated how digital food ordering improves
            speed, accuracy, and service quality. The system design focuses on
            simplicity, reliability, and scalability.
        </p>
    </div>

    <div class="section delivery">
        <h2>Our Delivery & Future Vision</h2>
        <p>
            We focus on fast and reliable order handling. Our future plans include
            integrating mobile payments, real-time order tracking, and expanding
            the system to support more restaurants and services.
        </p>
    </div>

</div>

</body>
</html>