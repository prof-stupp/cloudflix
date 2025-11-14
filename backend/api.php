<?php
// api.php
// API RESTful Procedural para gerenciamento de filmes com roteamento baseado em Query String.

// 1. Cabeçalhos e Configuração
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Inclui o arquivo de conexão (que usa PDO e MySQL)
include_once 'dbconfig.php';

// Trata o preflight OPTIONS (necessário para CORS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Inicializa a conexão
$pdo = getDbConnection();

// Obtém o método HTTP e os dados de entrada
$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents("php://input"), true); // Para POST/PUT

// --- Lógica de Roteamento Baseada na Query String (Modelo: ?resource=filmes&id=...) ---

// Obtém o recurso da query string (ex: 'filmes')
$resource = $_GET['resource'] ?? '';

// Obtém o ID da query string (ex: '2')
$id = $_GET['id'] ?? null;

// Funções CRUD para o recurso 'filmes'
include_once 'filmes_dao.php';

// --- Roteamento Principal ---
// Inclui o módulo de rotas que chamam as funções de CRUD
include_once 'routes.php';
?>