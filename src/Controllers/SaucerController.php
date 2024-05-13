<?php
namespace App\Controllers;

use App\Models\SaucerModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SaucerController{
    private $platillo = null;

    public function __construct(){
        $this -> platillo = new SaucerModel; 
    }
    public function newSaucer(Request $req, Response $res, $args){
        $body = json_decode($req->getBody());
        $res->withHeader('Content-type', 'application/json')
            ->getBody()->write(json_encode($this->platillo->newSaucer($body)));
        return $res;
    }
    public function getSaucers(Request $req, Response $res, $args){
        $res->withHeader('Content-type', 'application/json')
            ->getBody()->write(json_encode($this->platillo->getSaucers()));
        return $res;
    }
    
    public function deleteSaucers(Request $req, Response $res, $args){
        $body = json_decode($req->getBody());
        $res->withHeader('Content-type', 'application/json')
            ->getBody()->write(json_encode($this->platillo->deleteSaucers($body)));
        return $res;
    }
}