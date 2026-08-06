<?php

namespace App\Models;

use PDO;

class UsuarioModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $statement = $this->pdo->query('SELECT id, nome, email, meta_nutricional FROM usuarios ORDER BY id DESC');
        return $statement->fetchAll();
    }

    public function find(int $id): ?array
    {
        $statement = $this->pdo->prepare('SELECT id, nome, email, meta_nutricional FROM usuarios WHERE id = :id');
        $statement->execute(['id' => $id]);
        $result = $statement->fetch();
        return $result === false ? null : $result;
    }

    public function create(array $data): array
    {
        $statement = $this->pdo->prepare(
            'INSERT INTO usuarios (nome, email, meta_nutricional) VALUES (:nome, :email, :meta_nutricional)'
        );
        $statement->execute([
            'nome' => $data['nome'] ?? '',
            'email' => $data['email'] ?? '',
            'meta_nutricional' => $data['meta_nutricional'] ?? '',
        ]);

        return $this->find((int) $this->pdo->lastInsertId());
    }

    public function update(int $id, array $data): ?array
    {
        $statement = $this->pdo->prepare(
            'UPDATE usuarios SET nome = :nome, email = :email, meta_nutricional = :meta_nutricional WHERE id = :id'
        );
        $statement->execute([
            'id' => $id,
            'nome' => $data['nome'] ?? '',
            'email' => $data['email'] ?? '',
            'meta_nutricional' => $data['meta_nutricional'] ?? '',
        ]);

        return $this->find($id);
    }

    public function delete(int $id): void
    {
        $statement = $this->pdo->prepare('DELETE FROM usuarios WHERE id = :id');
        $statement->execute(['id' => $id]);
    }
}
