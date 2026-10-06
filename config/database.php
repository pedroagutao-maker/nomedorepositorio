<?php

class Database {
    private static $instance = null;

    public static function getConnection() {
        if (self::$instance === null) {
            $host = getenv('DB_HOST') ?: 'db.vcbqkyejpadllldbnpko.supabase.co';
            $port = getenv('DB_PORT') ?: '5432';
            $dbname = getenv('DB_NAME') ?: 'postgres';
            $user = getenv('DB_USER') ?: 'postgres';
            $password = getenv('DB_PASS') ?: '';

            // Driver DSN ajustado para PostgreSQL (pgsql)
            $dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";

            try {
                self::$instance = new PDO($dsn, $user, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
            } catch (PDOException $e) {
                die("<h2>Erro de Conexão com o Banco de Dados</h2><p>Detalhes: " . $e->getMessage() . "</p>");
            }
        }
        return self::$instance;
    }
}
