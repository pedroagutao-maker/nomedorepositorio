<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/config/database.php';

try {
    $pdo = Database::getConnection();
    echo "1. Conexao OK\n";

    require_once __DIR__ . '/app/Models/Treino.php';
    $m = new Treino();
    $r = $m->salvarTreino('Supino Reto', 80.0, 10, date('Y-m-d'));

    if ($r) {
        echo ">>> SUCESSO AO SALVAR NO BANCO <<<\n";
    } else {
        echo ">>> FALHA AO SALVAR <<<\n";
    }

    echo "Total no banco: " . $m->getTotalTreinos() . "\n";
} catch (Throwable $e) {
    echo "ERRO: " . $e->getMessage() . "\n";
}
