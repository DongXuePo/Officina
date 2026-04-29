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
$id_servizio = $_POST['id_servizio'] ?? '';

if (!is_numeric($id_officina) || !is_numeric($id_servizio)) {
    echo error("input invalido");
    exit;
}

if ($officina->associaServizioAOfficina($id_officina, $id_servizio)) {
     echo ok("servizio associato all'officina");
} else {
      echo error("errore assoccio servizio");
}
?>