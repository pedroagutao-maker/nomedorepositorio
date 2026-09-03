<?php

require_once __DIR__ . '/../Models/Treino.php';

class HomeController {
    public function index() {
        $treinoModel = new Treino();
        $dadosGrafico = $treinoModel->getEvolucaoCargas();

        // Passa os dados convertidos em JSON para a View
        $labels = json_encode(array_column($dadosGrafico, 'data'));
        $cargas = json_encode(array_column($dadosGrafico, 'carga'));

        require_once __DIR__ . '/../Views/home.php';
    }
}
