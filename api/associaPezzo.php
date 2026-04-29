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
$id_pezzo = $_POST['id_pezzo'] ?? '';
$quantita = $_POST['quantita'] ?? '';

if (!is_numeric($id_officina) || !is_numeric($id_pezzo) || !is_numeric($quantita)) {
    echo error("input invalido");
    exit;
}

if ($officina->associaPezzoAOfficina($id_officina, $id_pezzo, $quantita)) {
     echo ok("pezzo associato all'officina");
} else {
    echo error("errore assoccio pezzo");
}
?>