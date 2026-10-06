<?php

if (file_exists(__DIR__ . '/../../config/database.php')) {
    require_once __DIR__ . '/../../config/database.php';
} elseif (file_exists(__DIR__ . '/../config/database.php')) {
    require_once __DIR__ . '/../config/database.php';
}

class Treino {
    private $pdo;

    public function __construct() {
        try {
            if (class_exists('Database')) {
                $this->pdo = Database::getConnection();
            } else {
                $this->pdo = null;
            }
        } catch (Exception $e) {
            error_log("Erro de conexao no Model: " . $e->getMessage());
            $this->pdo = null;
        }
    }

    public function salvarTreino($exercicio, $carga, $repeticoes, $data) {
        if (!$this->pdo) return false;

        try {
            $sql = "INSERT INTO registros_treino (usuario_id, exercicio, carga, repeticoes, data_registro) 
                    VALUES (1, :exercicio, :carga, :repeticoes, :data)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                ':exercicio'  => $exercicio,
                ':carga'      => $carga,
                ':repeticoes' => $repeticoes,
                ':data'       => $data
            ]);
        } catch (PDOException $e) {
            error_log("Erro ao salvar treino: " . $e->getMessage());
            return false;
        }
    }

    public function getHistoricoCompleto() {
        if (!$this->pdo) return [];
        try {
            $stmt = $this->pdo->query("SELECT * FROM registros_treino WHERE usuario_id = 1 ORDER BY data_registro DESC, id DESC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getTotalTreinos() {
        if (!$this->pdo) return 0;
        try {
            return $this->pdo->query("SELECT COUNT(*) FROM registros_treino WHERE usuario_id = 1")->fetchColumn() ?: 0;
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function getCargaMaxima($exercicio = 'Supino Reto') {
        if (!$this->pdo) return 0;
        try {
            $stmt = $this->pdo->prepare("SELECT MAX(carga) FROM registros_treino WHERE usuario_id = 1 AND exercicio = :exercicio");
            $stmt->execute([':exercicio' => $exercicio]);
            return $stmt->fetchColumn() ?: 0;
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function getVolumeSemanal() {
        if (!$this->pdo) return 0;
        try {
            return $this->pdo->query("SELECT SUM(carga * repeticoes) FROM registros_treino WHERE usuario_id = 1 AND data_registro >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)")->fetchColumn() ?: 0;
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function getFichasTreino() {
        if (!$this->pdo) return [];
        try {
            return $this->pdo->query("SELECT * FROM fichas_treino WHERE usuario_id = 1 ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            return [];
        }
    }
}
