<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/db.php';

$app = AppFactory::create();
$db = new DB();
$db->init();

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world");
    return $response;
});

require __DIR__ . '/../routes/users.php';
require __DIR__ . '/../routes/messages.php';


$app->run();
