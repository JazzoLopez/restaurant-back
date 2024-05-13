<?php
namespace App\Controllers;

use App\Models\ReservationModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Firebase\JWT\Key;
use Firebase\JWT\JWT;


class ReservationController
{
    private $reservacion = null;

    public function __construct()
    {
        $this->reservacion = new ReservationModel();
    }

    public function getReservations(Request $req, Response $res, $args)
    {

        $body = json_decode($req->getBody());
        $jwt = $body->jwt;
        $decodedToken = JWT::decode($jwt, new key($_ENV['JWT_SECRET'], 'HS256'));
        $userId = $decodedToken->user_id;
        $res->withHeader('Content-type', 'application/json')
            ->getBody()->write(json_encode($this->reservacion->getReservations($userId)));
        return $res;
    }

    public function newReservations(Request $req, Response $res, $args)
    {
        $body = json_decode($req->getBody());
        $res->withHeader('Content-type', 'application/json')
            ->getBody()->write(json_encode($this->reservacion->newReservations($body)));
        return $res;
    }

    public function deleteReservations(Request $req, Response $res, $args)
    {
        $body = json_decode($req->getBody());
        $res->withHeader('Content-type', 'application/json')
            ->getBody()->write(json_encode($this->reservacion->deleteReservations($body)));
        return $res;
    }
}