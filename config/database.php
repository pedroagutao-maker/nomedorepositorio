<?php

class Database {
    private static $instance = null;

    public static function getConnection() {
        if (self::$instance === null) {
            $host = getenv('DB_HOST') ?: 'localhost';
            $port = getenv('DB_PORT') ?: '3306';
            $dbname = getenv('DB_NAME') ?: 'pwrgenforce';
            $user = getenv('DB_USER') ?: 'root';
            $password = getenv('DB_PASS') ?: '';

            try {
                $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";
                self::$instance = new PDO($dsn, $user, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
            } catch (PDOException $e) {
                die("<div style='background:#111;color:#ff5555;padding:20px;font-family:sans-serif;'>
                    <h2>Erro Conexão Banco de Dados</h2>
                    <p><strong>Detalhes:</strong> " . htmlspecialchars($e->getMessage()) . "</p>
                </div>");
            }
        }
        return self::$instance;
    }
}
