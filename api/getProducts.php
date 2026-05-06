<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type:application/json");
require_once __DIR__ . "/../misc/functions.php";
require_once __DIR__ . "/../classes/Officina.php";

$shop = new Officina();
$servizi = $shop->getServizi();
$accessori = $shop->getAccessori();
$pezziRicambio = $shop->getPezziRicambio();
$officine = $shop->getOfficine();



echo json_encode([
    "status" => true,
    "data" => [
        "servizi" => $servizi,
        "accessori" => $accessori,
        "pezziRicambio" => $pezziRicambio,
        "officine" => $officine
    ]
]);
