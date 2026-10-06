<?php
require_once __DIR__ . '/../Models/Treino.php';

class HomeController {
    private $treinoModel;

    public function __construct() {
        if (!class_exists('Treino')) {
            die("Erro critico: A classe Treino nao foi encontrada no Model.");
        }
        $this->treinoModel = new Treino();
    }

    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao'])) {
            if ($_POST['acao'] === 'salvar_treino') {
                $exercicio  = filter_input(INPUT_POST, 'exercicio', FILTER_SANITIZE_SPECIAL_CHARS);
                $carga      = filter_input(INPUT_POST, 'carga', FILTER_VALIDATE_FLOAT);
                $repeticoes = filter_input(INPUT_POST, 'repeticoes', FILTER_VALIDATE_INT);
                $data       = filter_input(INPUT_POST, 'data', FILTER_DEFAULT) ?? date('Y-m-d');

                if (!empty($exercicio) && $carga > 0 && $repeticoes > 0) {
                    $this->treinoModel->salvarTreino($exercicio, $carga, $repeticoes, $data);
                }
                
                header('Location: ' . $_SERVER['REQUEST_URI']);
                exit;
            }
        }

        $historico     = $this->treinoModel->getHistoricoCompleto();
        $totalTreinos  = $this->treinoModel->getTotalTreinos();
        $cargaMaxima   = $this->treinoModel->getCargaMaxima();
        $volumeSemanal = $this->treinoModel->getVolumeSemanal();
        $fichas        = $this->treinoModel->getFichasTreino();

        require_once __DIR__ . '/../Views/home.php';
    }
}
