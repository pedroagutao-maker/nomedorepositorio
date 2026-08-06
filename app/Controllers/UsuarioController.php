<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use PDO;

class UsuarioController
{
    private UsuarioModel $model;

    public function __construct(PDO $pdo)
    {
        $this->model = new UsuarioModel($pdo);
    }

    public function handle(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];

        switch ($method) {
            case 'GET':
                echo json_encode($this->model->findAll());
                break;
            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);
                $created = $this->model->create($data);
                http_response_code(201);
                echo json_encode($created);
                break;
            case 'PUT':
                $data = json_decode(file_get_contents('php://input'), true);
                $updated = $this->model->update((int) $data['id'], $data);
                echo json_encode($updated);
                break;
            case 'DELETE':
                parse_str(file_get_contents('php://input'), $data);
                $this->model->delete((int) $data['id']);
                echo json_encode(['success' => true]);
                break;
            default:
                http_response_code(405);
                echo json_encode(['error' => 'Método não permitido']);
                break;
        }
    }
}
