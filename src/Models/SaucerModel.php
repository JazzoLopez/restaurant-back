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

    public function deleteSaucer($body) {
        $isExist = $this ->db -> from($this ->tbSaucers)->where($this ->saucersId, $body -> id)->fetch();
        if(!$isExist){
            return $this -> response ->SetResponse(false,"EL platillo no existe");
        }
        $data = $this ->db -> deleteFrom($this -> tbSaucers)->where($this -> saucersId, $body -> id)->execute();
        if ($data > 0) {
            return $this->response->SetResponse(true, 'Platillo eliminado correctamente.');
        } else {
            return $this->response->SetResponse(false, 'Error al eliminar');
        }
    }

    public function updateSaucer($body){
        $data = [
            'name' => $body->name,
            'description' => $body->description,
            'price' => $body->price,
            'image' => $body->image
        ];
        $isExist = $this ->db -> from($this ->tbSaucers)->where($this ->saucersId -> $body -> id)->first();
        if($isExist)
            return $this -> response ->SetResponse(false,"EL platillo no existe");

        $result = $this -> db -> update($this -> tbSaucers)->set($data)->where($this -> saucersId, $body->id)->execute();
        if($result){
            $this -> response -> result = $result;
            return $this->response->SetResponse(true, 'Platillo actualizado.');
        } else {
            return $this->response->SetResponse(false,'Error al actualizar.');
        }
    }
}