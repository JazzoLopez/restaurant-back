<?php
namespace App\Models;

use App\Models\DbModel,
App\Lib\Response;

class SaucerModel
{
    private $db = null;
    private $response;
    private $saucersId= 'id';
    private $tbSaucers = 'saucers';
    private $nombre = 'name';
    private $descripcion = 'description';
    private $precio = 'price';
    private $image = 'image';

    public function __construct()
    {
        $db = new DbModel();
        $this->db = $db->sqlPDO;
        $this->response = new Response();
    }

    public function newSaucer($body)
    {
        $data = [
            'name' => $body->name,
            'description' => $body->description,
            'price' => $body->price,
            'image' => $body->image
        ];
        $result = $this -> db ->insertInto($this -> tbSaucers) -> values($data)->execute();
        if($result){
        $this -> response -> result = $result;
        return $this->response->SetResponse(true, 'Platillo registrado.');
        } else {
            return $this->response->SetResponse(false,'Error al registrar.');
        }
    }

    public function getSaucers () {
        $data = $this -> db -> from($this -> tbSaucers)->fetchAll();
        if(count($data) > 0){
            $this -> response -> result = $data;
            return $this->response->SetResponse(true, 'Listado de platillos.');
        }   

        return $this->response->SetResponse(false,'Error al traer los platillos');
    }

    public function deleteSaucers($id) {
        $data = $this ->db -> delete($this -> tbSaucers)->where($this -> saucersId, $id)->excecute();
        if ($data > 0) {
            return $this->response->SetResponse(true, 'Platillo eliminado correctamente.');
        } else {
            return $this->response->SetResponse(false, 'Error al eliminar');
        }
    }

    public function updateSaucer($body){
        //TODO: logica para actualizar el platillo asi bn loco
    }
}