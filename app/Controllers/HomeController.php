<?php

require_once __DIR__ . '/../Models/Treino.php';

class HomeController {
    public function index() {
        $treinoModel = new Treino();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $acao = $_POST['acao'] ?? '';

            if ($acao === 'novo_treino') {
                $exercicio = trim($_POST['exercicio'] ?? 'Supino Reto');
                $carga = floatval($_POST['carga'] ?? 0);
                $repeticoes = intval($_POST['repeticoes'] ?? 0);
                $data = !empty($_POST['data']) ? $_POST['data'] : date('Y-m-d');
                
                if ($carga > 0 && $repeticoes > 0 && !empty($exercicio)) {
                    $treinoModel->salvarTreino(1, $exercicio, $carga, $repeticoes, $data);
                }
            } elseif ($acao === 'novo_peso') {
                $peso = floatval(str_replace(',', '.', $_POST['peso_corporal'] ?? 0));
                $data = !empty($_POST['data_peso']) ? $_POST['data_peso'] : date('Y-m-d');
                
                if ($peso > 0) {
                    $treinoModel->salvarPesoCorporal(1, $peso, $data);
                }
            }

            // Redireciona para evitar re-submissão do formulário
            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit;
        }

        $totalTreinos = $treinoModel->getTotalTreinos(1);
        $cargaMaxima = $treinoModel->getCargaMaxima(1, 'Supino Reto');
        $volumeSemanal = $treinoModel->getVolumeSemanal(1);
        $historico = $treinoModel->getHistoricoCompleto(1);
        $fichas = $treinoModel->getFichasTreino(1);
        $historicoPeso = $treinoModel->getHistoricoPeso(1);

        $exerciciosRegistrados = !empty($historico) ? array_column($historico, 'exercicio') : [];
        $gruposTrabalhados = [
            'Peitoral' => in_array('Supino Reto', $exerciciosRegistrados),
            'Pernas'   => in_array('Agachamento', $exerciciosRegistrados),
            'Costas'   => in_array('Levantamento Terra', $exerciciosRegistrados),
            'Ombros'   => in_array('Desenvolvimento', $exerciciosRegistrados),
            'Braços'   => in_array('Rosca Direta', $exerciciosRegistrados) || in_array('Tríceps Pulley', $exerciciosRegistrados)
        ];

        $dadosGrafico = $treinoModel->getEvolucaoCargas(1, 'Supino Reto');
        $labels = json_encode(!empty($dadosGrafico) ? array_column($dadosGrafico, 'data') : []);
        $cargas = json_encode(!empty($dadosGrafico) ? array_column($dadosGrafico, 'carga') : []);

        require_once __DIR__ . '/../Views/home.php';
    }
}
