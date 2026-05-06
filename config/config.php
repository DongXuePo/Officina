<?php

class Config
{
    static public $hostname;
    static public $username;
    static public $password;
    static public $dbname;

    static public function loadEnv()
    {
        $envFile = __DIR__ . '/../default.env';
        if (file_exists($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos($line, '=') !== false) {
                    list($key, $value) = explode('=', $line, 2);
                    $key = trim($key);
                    $value = trim($value);
                    switch ($key) {
                        case 'DB_HOST':
                            self::$hostname = $value;
                            break;
                        case 'DB_USER':
                            self::$username = $value;
                            break;
                        case 'DB_PASS':
                            self::$password = $value;
                            break;
                        case 'DB_NAME':
                            self::$dbname = $value;
                            break;
                    }
                }
            }
        } else {
            // Fallback ai valori locali se default.env non esiste
            self::$hostname = "localhost";
            self::$username = "root";
            self::$password = "";
            self::$dbname = "mzlhyphg_wp759";
        }
    }
}

// Carica le variabili d'ambiente all'avvio
Config::loadEnv();
