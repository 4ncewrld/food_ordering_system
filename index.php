<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>4nce Food Ordering System</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family: Arial, sans-serif;
}

body{
    background:#f4f4f4;
}

/* ===== HEADER ===== */
header{
    background: linear-gradient(to right,#ff7a18,#ffb347);
    padding:20px 40px;
}

.header-container{
    display:grid;
    grid-template-columns:1fr auto 1fr;
    align-items:center;
}

.logo{
    grid-column:2;
    text-align:center;
    font-size:32px;
    font-weight:bold;
}

.logo span:nth-child(1){color:#00ffd5;}
.logo span:nth-child(2){color:#ffff00;}
.logo span:nth-child(3){color:#ffffff;}

.nav{
    grid-column:3;
    text-align:right;
}

.nav a{
    color:white;
    text-decoration:none;
    margin-left:20px;
    font-weight:bold;
}

.nav a:hover{
    text-decoration:underline;
}

/* ===== HERO ===== */
.hero{
    background:linear-gradient(to right,#ff7a18,#ff5722);
    color:white;
    text-align:center;
    padding:60px 20px;
}

.hero h1{
    font-size:36px;
    margin-bottom:10px;
}

.hero p{
    font-size:18px;
    max-width:700px;
    margin:auto;
}

.hero button{
    margin-top:20px;
    padding:12px 25px;
    border:none;
    background:#222;
    color:white;
    font-size:16px;
    cursor:pointer;
    border-radius:5px;
}

.hero button:hover{
    background:#000;
}

/* ===== SECTIONS ===== */
.section-container{
    display:flex;
    justify-content:space-around;
    padding:40px 20px;
    background:white;
    flex-wrap:wrap;
}

.section{
    width:45%;
    text-align:center;
    margin-bottom:20px;
}

.section h2{
    color:#ff5722;
    margin-bottom:15px;
}

.section p{
    color:#333;
    line-height:1.6;
}

/* ===== FOOTER ===== */
footer{
    background:#222;
    color:white;
    text-align:center;
    padding:15px;
    font-size:14px;
}
</style>
</head>

<body>

<header>
    <div class="header-container">

        <div></div>

        <div class="logo">
            <span>4nce</span>
            <span> Food Ordering </span>
            <span>System</span>
        </div>

        <div class="nav">
            <a href="index.php">Home</a>
            <a href="about.php">About Us</a>
            <a href="privacy.php">Privacy Policy</a>
            <a href="submit_feedback.php">Feedback</a>
            <a href="terms.php">Terms</a>
        </div>

    </div>
</header>

<section class="hero">
    <h1>Fast & Reliable Food Ordering Platform</h1>
    <p>
        A modern food ordering system that allows customers to explore food items,
        place orders easily, and enjoy fast and reliable delivery services.
    </p>

    <!-- UPDATED BUTTON LINK -->
    <button onclick="location.href='customer_products.php'">
        View Our Foods
    </button>
</section>

<section class="section-container">

    <div class="section">
        <h2>Why Choose 4nce</h2>
        <p>
            We provide a simple, fast, and secure food ordering experience.
            Customers can browse menus, place orders easily, and receive
            timely deliveries with guaranteed satisfaction.
        </p>
    </div>

    <div class="section">
        <h2>Our Services</h2>
        <p>
            Online food ordering, real-time order processing,
            reliable delivery services, and customer support
            designed to meet modern food business needs.
        </p>
    </div>

</section>

<footer>
    &copy; 2026 4nce Food Ordering System. All Rights Reserved.
</footer>

</body>
</html>