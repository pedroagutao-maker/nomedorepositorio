<?php

require_once __DIR__ . '/../../config/database.php';

class Treino {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
        $this->criarTabelasAutomaticamente();
    }

    // Cria as tabelas necessárias no MySQL do Render automaticamente se não existirem
    private function criarTabelasAutomaticamente() {
        try {
            $sqlPeso = "CREATE TABLE IF NOT EXISTS peso_corporal (
                id INT AUTO_INCREMENT PRIMARY KEY,
                usuario_id INT NOT NULL DEFAULT 1,
                peso DECIMAL(5,2) NOT NULL,
                data_registro DATE NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );";

            $sqlFichas = "CREATE TABLE IF NOT EXISTS fichas_treino (
                id INT AUTO_INCREMENT PRIMARY KEY,
                usuario_id INT NOT NULL DEFAULT 1,
                nome_ficha VARCHAR(100) NOT NULL,
                exercicios TEXT NOT NULL
            );";

            $this->db->exec($sqlPeso);
            $this->db->exec($sqlFichas);

            // Popula fichas padrão se a tabela estiver vazia
            $stmt = $this->db->query("SELECT COUNT(*) as total FROM fichas_treino");
            if ($stmt && $stmt->fetch()['total'] == 0) {
                $sqlSeed = "INSERT INTO fichas_treino (usuario_id, nome_ficha, exercicios) VALUES
                (1, 'Ficha A - Peito, Ombro e Tríceps', 'Supino Reto, Desenvolvimento, Tríceps Pulley'),
                (1, 'Ficha B - Costas e Bíceps', 'Levantamento Terra, Puxada Alta, Rosca Direta'),
                (1, 'Ficha C - Pernas Completo', 'Agachamento, Leg Press, Cadeira Extensora');";
                $this->db->exec($sqlSeed);
            }
        } catch (Exception $e) {
            // Silencioso se der erro para não travar a aplicação
        }
    }

    public function getEvolucaoCargas($usuarioId = 1, $exercicio = 'Supino Reto') {
        $sql = "SELECT DATE_FORMAT(data_registro, '%d/%m') as data, carga 
                FROM registros_treino 
                WHERE usuario_id = :usuario_id AND exercicio = :exercicio 
                ORDER BY data_registro ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
        $stmt->bindParam(':exercicio', $exercicio, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll() ?: [];
    }

    public function salvarTreino($usuarioId, $exercicio, $carga, $repeticoes, $data) {
        $sql = "INSERT INTO registros_treino (usuario_id, exercicio, carga, repeticoes, data_registro) 
                VALUES (:usuario_id, :exercicio, :carga, :repeticoes, :data_registro)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
        $stmt->bindParam(':exercicio', $exercicio, PDO::PARAM_STR);
        $stmt->bindParam(':carga', $carga);
        $stmt->bindParam(':repeticoes', $repeticoes, PDO::PARAM_INT);
        $stmt->bindParam(':data_registro', $data);
        return $stmt->execute();
    }

    public function getTotalTreinos($usuarioId = 1) {
        $sql = "SELECT COUNT(*) as total FROM registros_treino WHERE usuario_id = :usuario_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch();
        return $resultado['total'] ?? 0;
    }

    public function getCargaMaxima($usuarioId = 1, $exercicio = 'Supino Reto') {
        $sql = "SELECT MAX(carga) as max_carga FROM registros_treino WHERE usuario_id = :usuario_id AND exercicio = :exercicio";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
        $stmt->bindParam(':exercicio', $exercicio, PDO::PARAM_STR);
        $stmt->execute();
        $resultado = $stmt->fetch();
        return $resultado['max_carga'] ?? 0;
    }

    public function getVolumeSemanal($usuarioId = 1) {
        $sql = "SELECT SUM(carga * repeticoes) as volume 
                FROM registros_treino 
                WHERE usuario_id = :usuario_id AND data_registro >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch();
        return round(($res['volume'] ?? 0) / 1000, 2);
    }

    public function getHistoricoCompleto($usuarioId = 1) {
        $sql = "SELECT id, exercicio, carga, repeticoes, DATE_FORMAT(data_registro, '%d/%m/%Y') as data_formatada 
                FROM registros_treino 
                WHERE usuario_id = :usuario_id 
                ORDER BY data_registro DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll() ?: [];
    }

    public function getFichasTreino($usuarioId = 1) {
        $sql = "SELECT * FROM fichas_treino WHERE usuario_id = :usuario_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll() ?: [];
    }

    public function salvarPesoCorporal($usuarioId, $peso, $data) {
        $sql = "INSERT INTO peso_corporal (usuario_id, peso, data_registro) VALUES (:usuario_id, :peso, :data)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
        $stmt->bindParam(':peso', $peso);
        $stmt->bindParam(':data', $data);
        return $stmt->execute();
    }

    public function getHistoricoPeso($usuarioId = 1) {
        $sql = "SELECT peso, DATE_FORMAT(data_registro, '%d/%m') as data FROM peso_corporal WHERE usuario_id = :usuario_id ORDER BY data_registro ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll() ?: [];
    }
}
