<?php
namespace App\Controladores;

use App\Modelos\PlatilloModelo;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PlatilloControlador{
    private $platillo = null;

    public function __construct(){
        $this -> platillo = new PlatilloModelo; 
    }
    public function nuevoPlatillo(Request $req, Response $res, $args){
        $body = json_decode($req->getBody());
        $res->withHeader('Content-type', 'application/json')
            ->getBody()->write(json_encode($this->platillo->nuevoPlatillo($body)));
        return $res;
    }
    public function verPlatillos(Request $req, Response $res, $args){
        $res->withHeader('Content-type', 'application/json')
            ->getBody()->write(json_encode($this->platillo->verPlatillos()));
        return $res;
    }
    
    public function eliminarPlatillo(Request $req, Response $res, $args){
        $body = json_decode($req->getBody());
        $res->withHeader('Content-type', 'application/json')
            ->getBody()->write(json_encode($this->platillo->eliminarPlatillo($body)));
        return $res;
    }
}