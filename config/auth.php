<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Optional: check role
function requireRole($role) {
    if (!isset($_SESSION['role']) || $_SESSION['role'] != $role) {
        echo "Access denied.";
        exit;
    }
}
?>