<?php

require_once __DIR__ . '/../../config/database.php';

class Treino {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    // Busca o histórico de evolução do Supino Reto
    public function getEvolucaoCargas($usuarioId = 1, $exercicio = 'Supino Reto') {
        $sql = "SELECT DATE_FORMAT(data_registro, '%d/%m') as data, carga 
                FROM registros_treino 
                WHERE usuario_id = :usuario_id AND exercicio = :exercicio 
                ORDER BY data_registro ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
        $stmt->bindParam(':exercicio', $exercicio, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // Insere um novo registro de treino no banco
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
}
