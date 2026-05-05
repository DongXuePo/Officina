<?php

header("Content-Type:application/json");
require_once __DIR__ . "/../misc/functions.php";
require_once __DIR__ . "/../classes/Officina.php";

session_start();
if (!isset($_SESSION['dipendente'])) {
    echo error("accesso non autorizzato");
    exit;
}

$id_officina = $_SESSION['dipendente']['id_officina'];

$shop = new Officina();
$pezziMagazzino = $shop->getPezziPerOfficina($id_officina);

echo json_encode([
    "status" => true,
    "data" => $pezziMagazzino
]);
?>