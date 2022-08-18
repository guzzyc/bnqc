<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;




$app->get('/messages', function (Request $request, Response $response, array $args) {
    try {
        $db = new DB();
        $con=$db->connect();
        $stmt=$con->query('select * from messages');
        $msgs = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
        $msgs[] = [
            'sender' => $row['sender'],
            'to' => $row['toid'],           
            'message' => $row['msg']
         ];
        }
        $response->getBody()->write(json_encode($msgs));
        return $response->withHeader('content-type','application/json')->withStatus(200);
    }
    catch(Exception $e) {
        $response->getBody()->write($e);
    } 
});


$app->get('/messages/receiver/{id}', function (Request $request, Response $response, array $args) {
    try {
        $db = new DB();
        $con=$db->connect();
        $stmt=$con->prepare('select * from messages where toid = ?');
        $stmt->execute(array($args["id"]));
        $msgs = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $msgs[] = [
                'sender' => $row['sender'],
                'to' => $row['toid'],           
                'message' => $row['msg']
             ];
        }

        $response->getBody()->write(json_encode($msgs));
        return $response->withHeader('content-type','application/json')->withStatus(200);
    }
    catch(Exception $e) {
        $response->getBody()->write(json_encode($e));
        return $response->withHeader('content-type','application/json')->withStatus(500);
    } 
});

$app->get('/messages/sender/{id}', function (Request $request, Response $response, array $args) {
    try {
        $db = new DB();
        $con=$db->connect();
        $stmt=$con->prepare('select * from messages where sender = ?');
        $stmt->execute(array($args["id"]));
        $msgs = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $msgs[] = [
                'sender' => $row['sender'],
                'to' => $row['toid'],           
                'message' => $row['msg']
             ];
        }

        $response->getBody()->write(json_encode($msgs));
        return $response->withHeader('content-type','application/json')->withStatus(200);
    }
    catch(Exception $e) {
        $response->getBody()->write(json_encode($e));
        return $response->withHeader('content-type','application/json')->withStatus(500);
    } 
});

$app->post('/messages/send', function (Request $request, Response $response, array $args) {
    try {

        $db = new DB();
        $con=$db->connect();

        $msg=$request->getParam('msg');
        $sender=$request->getParam('sender');
        $toid=$request->getParam('toid');

        $stmt=$con->prepare('INSERT INTO messages(sender,toid,msg) VALUES(?,?,?)');
        $stmt->execute(array($sender, $toid,$msg));

        $response->getBody()->write(json_encode("Ok"));
        return $response->withHeader('content-type','application/json')->withStatus(200);
    }
    catch(Exception $e) {
        $response->getBody()->write(json_encode($e));
        return $response->withHeader('content-type','application/json')->withStatus(500);
    } 
});

