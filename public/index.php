<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Controllers/UsuarioController.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
$route = trim(str_replace($base, '', $uri), '/');

if ($route === '' || $route === 'home') {
    require_once __DIR__ . '/../app/Views/home.php';
    return;
}

header('Content-Type: application/json; charset=utf-8');

$pdo = getDatabaseConnection();
$controller = new App\Controllers\UsuarioController($pdo);

switch ($route) {
    case 'usuario':
        $controller->handle();
        break;
    default:
        http_response_code(404);
        echo json_encode(['error' => 'Rota não encontrada']);
        break;
}
