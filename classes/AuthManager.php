<?php

require_once __DIR__ . "/DatabaseManager.php";

class AuthManager
{
    public static function login($cognome, $nome, $password): bool
    {
        $db = new DatabaseManager();
        $conn = $db->getConnection();
        

        $stmt = $conn->prepare("SELECT id_cliente, password, status FROM cliente WHERE cognome = ? AND nome = ?");
        $stmt->bind_param("ss", $cognome, $nome);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if (isset($row['password']) && password_verify($password, $row['password']) && $row['status'] == 1) {
                return true;
            }
        }

        return false;
    }

    public static function register($cognome, $nome, $telefono, $password, $email): bool
    {
        $db = new DatabaseManager();
        $conn = $db->getConnection();

        $hashed = password_hash($password, PASSWORD_DEFAULT);
        
        $generateGuid = function() {
            $data = random_bytes(16);
            $data[6] = chr((ord($data[6]) & 0x0f) | 0x40);
            $data[8] = chr((ord($data[8]) & 0x3f) | 0x80);
            return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
        };

        self::ensurePendingTableExists($conn);

        $code = '';
        do {
            $code = $generateGuid();
            $chk = $conn->prepare("SELECT id_pending FROM pending_cliente WHERE codiceOTP = ?");
            if (!$chk) {
                throw new Exception("Errore prepare SELECT: " . $conn->error);
            }
            
            $chk->bind_param("s", $code);
            
            if (!$chk->execute()) {
                throw new Exception("Errore execute SELECT: " . $chk->error);
            }
            
            $res = $chk->get_result();
            $hasRows = $res && $res->num_rows > 0;
            if ($res) {
                $res->free_result();
            }
            $chk->close();
        } while ($hasRows);

        $date = date('Y-m-d');

        $stmt = $conn->prepare("INSERT INTO pending_cliente (cognome, nome, telefono, password, email, codiceOTP, dateOTP) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Errore prepare INSERT: " . $conn->error);
        }
        
        $stmt->bind_param("sssssss", $cognome, $nome, $telefono, $hashed, $email, $code, $date);
        
        $ok = $stmt->execute();
        if (!$ok) {
            throw new Exception("Errore execute INSERT: " . $stmt->error);
        }

        if ($ok) {
            require_once __DIR__ . "/../vendor/sendMail.php";
            $subject = 'Il tuo codice di verifica';
            $body = "<p>Ciao " . htmlspecialchars($nome) . ",</p>\n";
            $body .= "<p>Grazie per esserti registrato. Il tuo codice di verifica è:</p>\n";
            $body .= "<p><strong>$code</strong></p>\n";
            $body .= "<p>Inserisci questo codice nella pagina di verifica per completare la registrazione.</p>\n";
            @sendMail($email, $subject, $body);
        }

        $stmt->close();
        return $ok;
    }

    private static function ensurePendingTableExists($conn): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS pending_cliente (
            id_pending int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            cognome varchar(50) NOT NULL,
            nome varchar(50) NOT NULL,
            telefono varchar(20) NOT NULL,
            email varchar(50) NOT NULL,
            password varchar(255) NOT NULL,
            codiceOTP varchar(50) NOT NULL,
            dateOTP date NOT NULL,
            created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin";

        if (!$conn->query($sql)) {
            throw new Exception("Errore create pending table: " . $conn->error);
        }
    }

    public static function loginDipendente($username, $password): array
    {
        $db = new DatabaseManager();
        $conn = $db->getConnection();
        
        $stmt = $conn->prepare("SELECT id_dipendente, username, id_officina, password FROM dipendente WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $dipendente = $result->fetch_assoc();
            if (password_verify($password, $dipendente['password'])) {
                unset($dipendente['password']);
                return $dipendente;
            }
        }

        return [];
    }

    public static function isAdmin(): bool
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        //return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;ret
        return true;
    }
}