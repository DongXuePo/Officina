<?php
require_once "../classes/Officina.php";
require_once __DIR__ . "/../misc/functions.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo error("errore");
    exit;
}

session_start();
if (!isset($_SESSION['dipendente'])) {
    echo error("accesso non autorizzato");
    exit;
}

$id_officina = $_SESSION['dipendente']['id_officina'];
$officina = new Officina();

$id_pezzo = $_POST['id_pezzo'] ?? '';
$quantita = $_POST['quantita'] ?? '';

if (!is_numeric($id_pezzo) || !is_numeric($quantita) || $quantita <= 0) {
    echo error("input invalido");
    exit;
}

if ($officina->removeQuantitaPezzo($id_officina, $id_pezzo, $quantita)) {
    echo ok("quantità rimossa dal magazzino");
} else {
    echo error("errore rimozione quantità o quantità insufficiente");
}
?>