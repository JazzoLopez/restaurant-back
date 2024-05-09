<?php
namespace App\Controladores;
use App\Modelos\ReservacionModelos;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class ReservacionControlador{
    private $reservacion = null;

    public function __construct(){
        $this->reservacion = new ReservacionModelos;
    }

    public function verReservaciones ( Request $req, Response $res, $args ) {
        $body = json_decode($req->getBody());
        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->reservacion->verReservaciones($body)));
        return $res;
    } 

    public function nuevaReservacion(Request $req, Response $res, $args ) {
        $body = json_decode($req->getBody());
        $res->withHeader('Content-type','application/json')
            ->getBody()->write(json_encode( $this->reservacion->nuevaReservacion($body)));
        return $res;    
    }

    public function eliminarReservacion(Request $req, Response $res, $args ) {
        $parametro = $args['id'];
        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->reservacion->eliminarReservacion($parametro)));
        return $res;
    }
}