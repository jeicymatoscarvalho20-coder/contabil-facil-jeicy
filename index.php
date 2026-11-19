<?php
declare(strict_types=1);
session_start();

define('BASE_PATH', __DIR__);
require BASE_PATH . '/app/Core/Database.php';
require BASE_PATH . '/app/Core/helpers.php';
require BASE_PATH . '/app/Models/Usuario.php';
require BASE_PATH . '/app/Models/Cliente.php';
require BASE_PATH . '/app/Models/Obrigacao.php';
require BASE_PATH . '/app/Controllers/AuthController.php';
require BASE_PATH . '/app/Controllers/DashboardController.php';
require BASE_PATH . '/app/Controllers/ClienteController.php';
require BASE_PATH . '/app/Controllers/ObrigacaoController.php';
require BASE_PATH . '/app/Controllers/AvaliacaoController.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
$base = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
if ($base && $base !== '/') $uri = substr($uri, strlen($base)) ?: '/';
$uri = '/' . trim($uri, '/');
$method = $_SERVER['REQUEST_METHOD'];

$routes = [
    'GET /' => [DashboardController::class, 'index'],
    'GET /login' => [AuthController::class, 'form'],
    'POST /login' => [AuthController::class, 'login'],
    'POST /logout' => [AuthController::class, 'logout'],
    'GET /clientes' => [ClienteController::class, 'index'],
    'GET /clientes/novo' => [ClienteController::class, 'create'],
    'POST /clientes/salvar' => [ClienteController::class, 'store'],
    'GET /clientes/editar' => [ClienteController::class, 'edit'],
    'POST /clientes/atualizar' => [ClienteController::class, 'update'],
    'POST /clientes/excluir' => [ClienteController::class, 'delete'],
    'GET /obrigacoes' => [ObrigacaoController::class, 'index'],
    'GET /obrigacoes/nova' => [ObrigacaoController::class, 'create'],
    'POST /obrigacoes/salvar' => [ObrigacaoController::class, 'store'],
    'GET /obrigacoes/editar' => [ObrigacaoController::class, 'edit'],
    'POST /obrigacoes/atualizar' => [ObrigacaoController::class, 'update'],
    'POST /obrigacoes/excluir' => [ObrigacaoController::class, 'delete'],
    'GET /avaliacao' => [AvaliacaoController::class, 'form'],
    'POST /avaliacao/salvar' => [AvaliacaoController::class, 'store'],
];

$key = $method . ' ' . $uri;
if (isset($routes[$key])) {
    [$class, $action] = $routes[$key];
    (new $class())->$action();
    exit;
}
http_response_code(404);
$title = 'Página não encontrada';
require BASE_PATH . '/app/Views/errors/404.php';
