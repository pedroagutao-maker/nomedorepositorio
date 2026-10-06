<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$controllerPath = __DIR__ . '/../app/Controllers/HomeController.php';

if (!file_exists($controllerPath)) {
    die("Erro critico: O ficheiro HomeController.php nao foi encontrado em: " . realpath(__DIR__ . '/..') . "/app/Controllers/");
}

require_once $controllerPath;

if (!class_exists('HomeController')) {
    die("Erro critico: A classe HomeController nao esta definida no ficheiro.");
}

$controller = new HomeController();
$controller->index();
