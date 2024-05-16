<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: *");
header('Content-Type: application/json');
    
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$app = AppFactory::create();



require __DIR__ . '/src/loadApp.php';

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write(json_encode([
        "status"=>"server is on"
    ]));
    return $response;
});

$app->run();