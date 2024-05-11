<?php
namespace App\Modelos;

use App\Modelos\DbModel,
App\Lib\Response;

class PlatilloModelo
{
    private $db = null;
    private $response;
    private $nombre = 'name';
    private $descripcion = 'description';
    private $precio = 'price';
    private $image = 'image';
    private $tbSaucers = 'saucers';

    public function __construct()
    {
        $db = new DbModel();
        $this->db = $db->sqlPDO;
        $this->response = new Response();
    }

    public function nuevoPlatillo($body)
    {
        $data = [
            'name' => $body->name,
            'description' => $body->description,
            'price' => $body->price,
            'image' => $body->image
        ];
        $result = $this -> db ->insertInto($this -> tbSaucers) -> values($data);
        if($result){
        $this -> response -> result = $result;
        return $this->response->SetResponse(true, 'Platillo registrado');
        } else {
            return $this->response->SetResponse(false,'Error al registrar ');
        }
    }
}