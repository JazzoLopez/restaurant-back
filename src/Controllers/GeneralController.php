<?php
namespace App\Controllers;

use App\Models\SaucerModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class general{

    public function verifyAccount(Request $req, Response $res, $args)
    {
        $token = $args['token'];
        $body = json_decode($req->getBody());

        $res->withHeader('Content-type', 'application/json')
            ->getBody()->write($token);
        return $res;
    }
}