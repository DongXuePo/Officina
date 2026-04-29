<?php
require_once "../classes/AuthManager.php";
require_once __DIR__ . "/../misc/functions.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo error("errore");
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

if (empty($username) || empty($password)) {
    echo error("tutti spazi richiesti");
    exit;
}

$dipendente = AuthManager::loginDipendente($username, $password);

if (!empty($dipendente)) {
    if (!isset($_SESSION)) session_start();
    $_SESSION['dipendente'] = $dipendente;
    $_SESSION['is_admin'] = (isset($dipendente['username']) && $dipendente['username'] === 'admin') || (isset($dipendente['id_officina']) && intval($dipendente['id_officina']) === 1);
    echo ok("successo");
} else {
    echo error("invalido");
}
?>