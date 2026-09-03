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
}
