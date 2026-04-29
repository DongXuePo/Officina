<?php

require_once __DIR__ . "/../misc/functions.php";
require_once __DIR__ . "/../classes/DatabaseManager.php";

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

header("Content-Type: application/json; charset=UTF-8");
session_start();
session_regenerate_id(true);

try {
    if (!isset($_POST['code']) || empty(trim($_POST['code']))) {
        echo error('Inserisci il codice di verifica.');
        exit;
    }

    $code = trim($_POST['code']);

    $db = new DatabaseManager();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT id_pending, cognome, nome, telefono, email, password, dateOTP FROM pending_cliente WHERE codiceOTP = ?");
    if (!$stmt) {
        throw new Exception("Errore prepare SELECT: " . $conn->error);
    }

    $stmt->bind_param("s", $code);
    if (!$stmt->execute()) {
        throw new Exception("Errore execute SELECT: " . $stmt->error);
    }

    $res = $stmt->get_result();
    if (!$res || $res->num_rows !== 1) {
        echo error('Codice di verifica non valido o scaduto.');
        exit;
    }

    $row = $res->fetch_assoc();
    $id_pending = $row['id_pending'];

    $ins = $conn->prepare("INSERT INTO cliente (cognome, nome, telefono, email, password, status, dateOTP) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if (!$ins) {
        throw new Exception("Errore prepare INSERT cliente: " . $conn->error);
    }

    $status = 1;
    $ins->bind_param("sssssis", $row['cognome'], $row['nome'], $row['telefono'], $row['email'], $row['password'], $status, $row['dateOTP']);
    if (!$ins->execute()) {
        throw new Exception("Errore execute INSERT cliente: " . $ins->error);
    }

    $newId = $conn->insert_id;
    $del = $conn->prepare("DELETE FROM pending_cliente WHERE id_pending = ?");
    if (!$del) {
        throw new Exception("Errore prepare DELETE: " . $conn->error);
    }
    $del->bind_param("i", $id_pending);
    if (!$del->execute()) {
        throw new Exception("Errore execute DELETE: " . $del->error);
    }

    $_SESSION['id_cliente'] = $newId;
    $_SESSION['cognome'] = $row['cognome'];
    $_SESSION['nome'] = $row['nome'];
    $_SESSION['logged_in'] = true;
    $_SESSION['confirm_message'] = ['success' => true, 'message' => 'Registrazione completata. Benvenuto!'];
    session_write_close();

    echo ok('Codice verificato. Benvenuto!');
    exit;
} catch (Throwable $t) {
    error_log('VerifyCode error: ' . $t->getMessage());
    error_log('VerifyCode trace: ' . $t->getTraceAsString());
    echo error('Errore interno durante la verifica del codice.');
    exit;
}
