<?php

require_once __DIR__ . '/../../config/database.php';

class Treino {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
        $this->criarTabelasAutomaticamente();
    }

    private function criarTabelasAutomaticamente() {
        try {
            // Tabela de Treinos
            $sqlTreino = "CREATE TABLE IF NOT EXISTS registros_treino (
                id INT AUTO_INCREMENT PRIMARY KEY,
                usuario_id INT NOT NULL DEFAULT 1,
                exercicio VARCHAR(100) NOT NULL,
                carga DECIMAL(6,2) NOT NULL,
                repeticoes INT NOT NULL,
                data_registro DATE NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

            // Tabela de Peso
            $sqlPeso = "CREATE TABLE IF NOT EXISTS peso_corporal (
                id INT AUTO_INCREMENT PRIMARY KEY,
                usuario_id INT NOT NULL DEFAULT 1,
                peso DECIMAL(5,2) NOT NULL,
                data_registro DATE NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

            // Tabela de Fichas
            $sqlFichas = "CREATE TABLE IF NOT EXISTS fichas_treino (
                id INT AUTO_INCREMENT PRIMARY KEY,
                usuario_id INT NOT NULL DEFAULT 1,
                nome_ficha VARCHAR(100) NOT NULL,
                exercicios TEXT NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

            $this->db->exec($sqlTreino);
            $this->db->exec($sqlPeso);
            $this->db->exec($sqlFichas);
        } catch (PDOException $e) {
            error_log("Erro na criação de tabelas: " . $e->getMessage());
        }
    }

    public function salvarTreino($usuarioId, $exercicio, $carga, $repeticoes, $data) {
        try {
            $sql = "INSERT INTO registros_treino (usuario_id, exercicio, carga, repeticoes, data_registro) 
                    VALUES (:usuario_id, :exercicio, :carga, :repeticoes, :data_registro)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':usuario_id' => $usuarioId,
                ':exercicio' => $exercicio,
                ':carga' => $carga,
                ':repeticoes' => $repeticoes,
                ':data_registro' => $data
            ]);
        } catch (PDOException $e) {
            error_log("Erro ao salvar treino: " . $e->getMessage());
            return false;
        }
    }

    public function salvarPesoCorporal($usuarioId, $peso, $data) {
        try {
            $sql = "INSERT INTO peso_corporal (usuario_id, peso, data_registro) 
                    VALUES (:usuario_id, :peso, :data_registro)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':usuario_id' => $usuarioId,
                ':peso' => $peso,
                ':data_registro' => $data
            ]);
        } catch (PDOException $e) {
            error_log("Erro ao salvar peso corporal: " . $e->getMessage());
            return false;
        }
    }

    public function getEvolucaoCargas($usuarioId = 1, $exercicio = 'Supino Reto') {
        try {
            $sql = "SELECT DATE_FORMAT(data_registro, '%d/%m') as data, carga 
                    FROM registros_treino 
                    WHERE usuario_id = :usuario_id AND exercicio = :exercicio 
                    ORDER BY data_registro ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':usuario_id' => $usuarioId, ':exercicio' => $exercicio]);
            return $stmt->fetchAll() ?: [];
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getTotalTreinos($usuarioId = 1) {
        try {
            $sql = "SELECT COUNT(*) as total FROM registros_treino WHERE usuario_id = :usuario_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':usuario_id' => $usuarioId]);
            $res = $stmt->fetch();
            return $res['total'] ?? 0;
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function getCargaMaxima($usuarioId = 1, $exercicio = 'Supino Reto') {
        try {
            $sql = "SELECT MAX(carga) as max_carga FROM registros_treino WHERE usuario_id = :usuario_id AND exercicio = :exercicio";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':usuario_id' => $usuarioId, ':exercicio' => $exercicio]);
            $res = $stmt->fetch();
            return $res['max_carga'] ?? 0;
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function getVolumeSemanal($usuarioId = 1) {
        try {
            $sql = "SELECT SUM(carga * repeticoes) as volume 
                    FROM registros_treino 
                    WHERE usuario_id = :usuario_id AND data_registro >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':usuario_id' => $usuarioId]);
            $res = $stmt->fetch();
            return round(($res['volume'] ?? 0) / 1000, 2);
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function getHistoricoCompleto($usuarioId = 1) {
        try {
            $sql = "SELECT id, exercicio, carga, repeticoes, DATE_FORMAT(data_registro, '%d/%m/%Y') as data_formatada 
                    FROM registros_treino 
                    WHERE usuario_id = :usuario_id 
                    ORDER BY data_registro DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':usuario_id' => $usuarioId]);
            return $stmt->fetchAll() ?: [];
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getFichasTreino($usuarioId = 1) {
        try {
            $sql = "SELECT * FROM fichas_treino WHERE usuario_id = :usuario_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':usuario_id' => $usuarioId]);
            return $stmt->fetchAll() ?: [];
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getHistoricoPeso($usuarioId = 1) {
        try {
            $sql = "SELECT peso, DATE_FORMAT(data_registro, '%d/%m/%Y') as data FROM peso_corporal WHERE usuario_id = :usuario_id ORDER BY data_registro DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':usuario_id' => $usuarioId]);
            return $stmt->fetchAll() ?: [];
        } catch (PDOException $e) {
            return [];
        }
    }
}
