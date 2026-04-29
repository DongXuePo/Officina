<?php

require_once __DIR__ . "/../misc/functions.php";
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

ob_start();

header("Content-Type: application/json; charset=UTF-8");

try {
	if (!isset($_POST["cognome"]) || !isset($_POST["nome"]) || !isset($_POST["password"]) || !isset($_POST["telefono"]) || !isset($_POST["email"])) {
		echo error("tutti campi richiesti");
		exit;
	}

	$cognome = $_POST['cognome'];
	$nome = $_POST['nome'];
	$telefono = $_POST['telefono'];
	$password = $_POST['password'];
	$email = $_POST['email'];

	require_once __DIR__ . "/../classes/AuthManager.php";

	$ok = AuthManager::register($cognome, $nome, $telefono, $password, $email);

	if ($ok) {
		echo ok("registrazione effettuata. Controlla la tua email per il codice di verifica.");
		ob_end_flush();
		exit;
	}

	echo error("errore durante la registrazione");
	ob_end_flush();
	exit;
} catch (Throwable $t) {
	ob_end_clean();
	error_log('Register error: ' . $t->getMessage());
	error_log('Stack trace: ' . $t->getTraceAsString());
	echo error('errore interno durante la registrazione: ' . $t->getMessage());
	exit;
}

