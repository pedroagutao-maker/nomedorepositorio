<?php
// Exibe erros na tela para identificar falhas de banco/controller
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Carrega o Controller Principal
require_once __DIR__ . '/../app/Controllers/HomeController.php';

// Instancia e executa
$controller = new HomeController();
$controller->index();
