<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) { 
    session_start(); 
}

include "config/db.php";
include "navbar.php"; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Feedback</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background: #f8f9fa; color: #333; }
        .container { max-width: 550px; margin: 60px auto; background: #fff; padding: 40px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        h2 { color: #ff5722; text-align: center; font-size: 28px; margin-bottom: 10px; }
        p.subtitle { text-align: center; color: #666; margin-bottom: 30px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: #444; }
        input, textarea { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 15px; transition: 0.3s; box-sizing: border-box; }
        input:focus, textarea:focus { border-color: #ff5722; outline: none; box-shadow: 0 0 8px rgba(255,87,34,0.2); }
        .btn-submit { width: 100%; padding: 14px; background: #ff5722; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer; transition: 0.3s; margin-top: 10px; }
        .btn-submit:hover { background: #e64a19; transform: translateY(-2px); }
        .alert { padding: 15px; border-radius: 8px; text-align: center; margin-bottom: 20px; font-weight: 500; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>

<div class="container">
    <h2>Give Us a Review</h2>
    <p class="subtitle">Your feedback helps us serve you better!</p>

    <?php if(isset($_GET['status'])): ?>
        <?php if($_GET['status'] == 'success'): ?>
            <div class="alert success">✅ Review submitted successfully! Thank you.</div>
        <?php elseif($_GET['status'] == 'empty'): ?>
            <div class="alert error">⚠️ Please fill in all fields correctly.</div>
        <?php endif; ?>
    <?php endif; ?>

    <form action="submit_feedback.php" method="POST">
        <div class="form-group">
            <label>Full Name (Customer)</label>
            <input type="text" name="customer" placeholder="Enter your name" required>
        </div>
        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" placeholder="example@mail.com" required>
        </div>
        <div class="form-group">
            <label>Contact Number</label>
            <input type="tel" name="contact" placeholder="e.g. 0712345678" required>
        </div>
        <div class="form-group">
            <label>Your Review</label>
            <textarea name="review" rows="5" placeholder="Write your thoughts here..." required></textarea>
        </div>
        <button type="submit" class="btn-submit">Submit Review</button>
    </form>
</div>

</body>
</html>