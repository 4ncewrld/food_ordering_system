<?php
// 1. Anza session ili uweze kuifikia
session_start();

// 2. Futa data zote zilizopo kwenye session
$_SESSION = array();

// 3. Kama kuna session cookie, ifute pia
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 4. Haribu session kabisa
session_destroy();

// 5. Mrudishe mtumiaji kwenye ukurasa wa Login
header("Location: login.php");
exit;
?>