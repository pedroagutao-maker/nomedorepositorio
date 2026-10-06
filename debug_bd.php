<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/config/database.php';

echo "<h2>1. Testando Conexão com o Banco</h2>";
try {
    $pdo = Database::getConnection();
    echo "<p style='color:green;'>Conexão realizada com sucesso!</p>";
} catch (Exception $e) {
    die("<p style='color:red;'>Erro na conexão: " . $e->getMessage() . "</p>");
}

echo "<h2>2. Testando Inserção na Tabela 'registros_treino'</h2>";
try {
    $sql = "INSERT INTO registros_treino (usuario_id, exercicio, carga, repeticoes, data_registro) 
            VALUES (1, 'Teste Drastico', 50.0, 10, CURDATE())";
    $stmt = $pdo->prepare($sql);
    $res = $stmt->execute();

    if ($res) {
        echo "<p style='color:green;'>INSERÇÃO FUNCIONOU PERFEITAMENTE!</p>";
    } else {
        echo "<p style='color:red;'>Falha ao executar SQL de teste.</p>";
    }
} catch (PDOException $e) {
    echo "<p style='color:red;'>Erro de SQL: " . $e->getMessage() . "</p>";
}

echo "<h2>3. Últimos Registros do Banco</h2>";
try {
    $stmt = $pdo->query("SELECT * FROM registros_treino ORDER BY id DESC LIMIT 5");
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<pre>";
    print_r($dados);
    echo "</pre>";
} catch (PDOException $e) {
    echo "<p style='color:red;'>Erro ao ler tabela: " . $e->getMessage() . "</p>";
}
