<?php
require_once "../classes/Officina.php";
require_once __DIR__ . "/../misc/functions.php";
require_once __DIR__ . "/../classes/AuthManager.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo error("errore");
    exit;
}

if (!AuthManager::isAdmin()) {
    echo error("accesso non autorizzato");
    exit;
}

$officina = new Officina();

$descrizione = $_POST['descrizione'] ?? '';
$costo_unitario = $_POST['costo_unitario'] ?? '';

if (empty($descrizione) || !is_numeric($costo_unitario)) {
    echo error("input invalido");
    exit;
}

if ($officina->addAccessorio($descrizione, $costo_unitario)) {
    echo ok("accessorio aggiunto");
} else {
    echo error("errore aggiunta accessorio");
}
?>