<?php
namespace App\Controllers;

//EL nombre siempre es el mismo de la clase con la que trabajas ten cuidado
use App\Models\UserModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Lib\Views;

class UserController
{
    private $UserModel;
    private $Views;

    public function __construct()
    {
        $this->UserModel = new UserModel;
        $this->Views = new Views;
    }

    public function createUser(Request $req, Response $res, $args)
    {
        $userData = json_decode($req->getBody());

        $result = $this->UserModel->createUser($userData);

        // Preparar y enviar respuesta HTTP
        $res = $res->withHeader('Content-type', 'application/json');
        $res->getBody()->write(json_encode($result));
        return $res;
    }

    public function authenticateUser(Request $req, Response $res, $args)
    {
        $userData = json_decode($req->getBody());
        $result = $this->UserModel->authenticateUser($userData);
        $res = $res->withHeader('Content-type', 'application/json');
        $res->getBody()->write(json_encode($result));
        return $res;
    }

    public function updateUser(Request $req, Response $res, $args)
    {
        $body = json_decode($req->getBody());
        $result = $this->UserModel->updateUser($body);
        $res = $res->withHeader('Content-type', 'application/json');
        $res->getBody()->write(json_encode($result));
        return $res;
    }

    public function deleteUser(Request $req, Response $res, $args)
    {
        $body = json_decode($req->getBody());
        $result = $this->UserModel->deleteUser($body);
        $res = $res->withHeader('Content-type', 'application/json');
        $res->getBody()->write(json_encode($result));
        return $res;
    }

    public function getUsers(Request $req, Response $res, $args)
    {
        $result = $this->UserModel->getUsers();
        $res = $res->withHeader('Content-type', 'application/json');
        $res->getBody()->write(json_encode($result));
        return $res;
    }

    public function verifyAccount(Request $req, Response $res, $args)
    {
        $token = $args['token'];
        $result = $this->UserModel->verifyAccount($token);
        if ($result->response) {
            // Renderizar la plantilla de cuenta verificada
            $res->getBody()->write($this->Views->accountValidHtml($result));
            return $res->withHeader('Content-Type', 'text/html');
        } else {
            $res->getBody()->write($this->Views->accountInvalidHTML($result));
            return $res->withHeader('Content-Type', 'text/html');
        }
    }

}