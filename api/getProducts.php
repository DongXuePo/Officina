<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ob_start();
set_error_handler(function ($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});

header("Content-Type: application/json");
require_once __DIR__ . "/../misc/functions.php";
require_once __DIR__ . "/../classes/Officina.php";

try {
    $shop = new Officina();
    $servizi = $shop->getServizi();
    $accessori = $shop->getAccessori();
    $pezziRicambio = $shop->getPezziRicambio();
    $officine = $shop->getOfficine();

    ob_end_clean();
    restore_error_handler();

    echo json_encode([
        "status" => true,
        "data" => [
            "servizi" => $servizi,
            "accessori" => $accessori,
            "pezziRicambio" => $pezziRicambio,
            "officine" => $officine
        ]
    ]);
} catch (Throwable $e) {
    ob_end_clean();
    restore_error_handler();

    // Log dettagliato per debug
    error_log("Database connection error: " . $e->getMessage());
    error_log("Config loaded - Host: " . Config::$hostname . ", User: " . Config::$username . ", DB: " . Config::$dbname);

    echo error("Errore server: " . $e->getMessage());
}

