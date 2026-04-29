<?php
require_once __DIR__ . "/../misc/functions.php";

header('Content-Type: application/json');

if (!isset($_SESSION)) session_start();

// Unset session variables and destroy session
$_SESSION = array();
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();

echo ok("logout effettuato");
exit;
