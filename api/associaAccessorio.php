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

$id_officina = $_POST['id_officina'] ?? '';
$id_accessorio = $_POST['id_accessorio'] ?? '';
$quantita = $_POST['quantita'] ?? '';

if (!is_numeric($id_officina) || !is_numeric($id_accessorio) || !is_numeric($quantita)) {
    echo error("input invalido");
    exit;
}

if ($officina->associaAccessorioAOfficina($id_officina, $id_accessorio, $quantita)) {
    echo ok("accessorio associato all'officina");
} else {
    echo error("errore assoccio accessorio");
}
?>