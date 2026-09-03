<?php

require_once __DIR__ . '/../Models/Treino.php';

class HomeController {
    public function index() {
        $treinoModel = new Treino();

        // Se receber requisição POST, salva o novo treino
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'novo_treino') {
            $exercicio = $_POST['exercicio'] ?? 'Supino Reto';
            $carga = floatval($_POST['carga']);
            $repeticoes = intval($_POST['repeticoes']);
            $data = $_POST['data'] ?? date('Y-m-d');

            $treinoModel->salvarTreino(1, $exercicio, $carga, $repeticoes, $data);
            header('Location: /');
            exit;
        }

        $dadosGrafico = $treinoModel->getEvolucaoCargas();
        $labels = json_encode(array_column($dadosGrafico, 'data'));
        $cargas = json_encode(array_column($dadosGrafico, 'carga'));

        require_once __DIR__ . '/../Views/home.php';
    }
}
