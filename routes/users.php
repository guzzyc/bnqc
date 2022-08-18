<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;




$app->get('/users', function (Request $request, Response $response, $args) {
    try {
        $db = new DB();
        $con=$db->connect();
        $stmt=$con->query('select * from users');
        $users = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
        $users[] = [
            'id' => $row['uid'],
            'name' => $row['username']
         ];
        }
        $response->getBody()->write(json_encode($users));
        return $response->withHeader('content-type','application/json')->withStatus(200);
    }
    catch(Exception $e) {
        $response->getBody()->write($e);
    } 
});

$app->get('/users/{id}', function (Request $request, Response $response, array $args) {
    try {
        $db = new DB();
        $con=$db->connect();
        $stmt=$con->prepare('select * from users where uid = ?');
        $stmt->execute(array($args["id"]));
        $users = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
        $users[] = [
            'id' => $row['uid'],
            'name' => $row['username']
         ];
        }

        $response->getBody()->write(json_encode($users));
        return $response->withHeader('content-type','application/json')->withStatus(200);
    }
    catch(Exception $e) {
        $response->getBody()->write($e);
    } 
});
