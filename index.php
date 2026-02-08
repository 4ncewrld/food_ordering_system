<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>4nce Food Ordering System</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<!-- NAVBAR -->
<header class="navbar">
    <nav class="nav-left">
        <a href="#home">Home</a>
        <a href="#contact">Contact</a>
        <a href="#location">Location</a>
        <a href="#feedback">Feedback</a>
    </nav>

    <h1 class="logo">4nce Food Ordering System</h1>

    <nav class="nav-right">
        <a href="customer_products.php" class="btn">View Foods</a>
    </nav>
</header>

<!-- HERO / HOME -->
<section class="hero" id="home">
    <div class="hero-content">
        <h2>Delicious Foods, Delivered Fast</h2>
        <p>Order your favorite meals easily and quickly.</p>
        <a href="customer_products.php" class="btn big">Order Now</a>
    </div>
</section>

<!-- CONTACT -->
<section id="contact" class="section">
    <h2>Contact Us</h2>
    <p><strong>Phone:</strong> 0776837790</p>
    <p><strong>Email:</strong> alphonce1104mtenga@gmail.com</p>
</section>

<!-- LOCATION -->
<section id="location" class="section dark">
    <h2>Our Location</h2>
    <p>Boma, Kilimanjaro</p>
</section>

<!-- CUSTOMER FEEDBACK -->
<section id="feedback" class="section">
    <h2>Customer Feedback</h2>

    <form class="feedback-form">
        <input type="text" placeholder="Your Name" required>
        <textarea placeholder="Write your feedback here..." required></textarea>
        <button type="submit" class="btn big">Send Feedback</button>
    </form>

    <p class="note">
        Your feedback will be sent to the admin.
    </p>
</section>

<!-- FOOTER -->
<footer class="footer">
    <p>&copy; 2026 4nce Food Ordering System. All rights reserved.</p>
</footer>

</body>
</html><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>4nce Food Ordering System</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<!-- NAVBAR -->
<header class="navbar">
    <nav class="nav-left">
        <a href="#home">Home</a>
        <a href="#contact">Contact</a>
        <a href="#location">Location</a>
        <a href="#feedback">Feedback</a>
    </nav>

    <h1 class="logo">4nce Food Ordering System</h1>

    <nav class="nav-right">
        <a href="customer_products.php" class="btn">View Foods</a>
    </nav>
</header>

<!-- HERO / HOME -->
<section class="hero" id="home">
    <div class="hero-content">
        <h2>Delicious Foods, Delivered Fast</h2>
        <p>Order your favorite meals easily and quickly.</p>
        <a href="customer_products.php" class="btn big">Order Now</a>
    </div>
</section>

<!-- CONTACT -->
<section id="contact" class="section">
    <h2>Contact Us</h2>
    <p><strong>Phone:</strong> 0776837790</p>
    <p><strong>Email:</strong> alphonce1104mtenga@gmail.com</p>
</section>

<!-- LOCATION -->
<section id="location" class="section dark">
    <h2>Our Location</h2>
    <p>Boma, Kilimanjaro</p>
    <p>Country: Tanzania</p>
    <p>P.O. Box 57</p>
    <p>Opposite Panone</p>
</section>

<!-- CUSTOMER FEEDBACK -->
<section id="feedback" class="section">
    <h2>Customer Feedback</h2>

    <form class="feedback-form" method="POST" action="submit_feedback.php">
    <input type="text" name="name" placeholder="Your Name" required>
    <textarea name="message" placeholder="Write your feedback here..." required></textarea>
    <button type="submit" class="btn big">Send Feedback</button>
</form>

    <p class="note">
        Your feedback will be sent to the admin.
    </p>
</section>

<!-- FOOTER -->
<footer class="footer">
    <p>&copy; 2026 4nce Food Ordering System. All rights reserved.</p>
</footer>

</body>
</html>