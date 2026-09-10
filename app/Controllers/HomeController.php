<?php

require_once __DIR__ . '/../Models/Treino.php';

class HomeController {
    public function index() {
        $treinoModel = new Treino();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'novo_treino') {
            $exercicio = $_POST['exercicio'] ?? 'Supino Reto';
            $carga = floatval($_POST['carga']);
            $repeticoes = intval($_POST['repeticoes']);
            $data = $_POST['data'] ?? date('Y-m-d');

            $treinoModel->salvarTreino(1, $exercicio, $carga, $repeticoes, $data);
            header('Location: /');
            exit;
        }

        // Busca de métricas com verificação defensiva
        $totalTreinos = method_exists($treinoModel, 'getTotalTreinos') ? $treinoModel->getTotalTreinos(1) : 0;
        $cargaMaxima = method_exists($treinoModel, 'getCargaMaxima') ? $treinoModel->getCargaMaxima(1, 'Supino Reto') : 0;
        $historico = method_exists($treinoModel, 'getHistoricoCompleto') ? $treinoModel->getHistoricoCompleto(1) : [];

        // Mapeamento dos grupos musculares
        $exerciciosRegistrados = !empty($historico) ? array_column($historico, 'exercicio') : [];
        $gruposTrabalhados = [
            'Peitoral' => in_array('Supino Reto', $exerciciosRegistrados),
            'Pernas'   => in_array('Agachamento', $exerciciosRegistrados),
            'Costas'   => in_array('Levantamento Terra', $exerciciosRegistrados),
            'Ombros'   => in_array('Desenvolvimento', $exerciciosRegistrados),
            'Braços'   => false
        ];

        $dadosGrafico = $treinoModel->getEvolucaoCargas(1, 'Supino Reto');
        $labels = json_encode(!empty($dadosGrafico) ? array_column($dadosGrafico, 'data') : []);
        $cargas = json_encode(!empty($dadosGrafico) ? array_column($dadosGrafico, 'carga') : []);

        require_once __DIR__ . '/../Views/home.php';
    }
}
