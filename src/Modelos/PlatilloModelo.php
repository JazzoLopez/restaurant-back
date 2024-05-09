<?php
namespace App\Modelos;
use App\Modelos\DbModel,
    App\Lib\Response;

class PlatilloModelo{
    private $response;  
    private $nombre = 'name';
    private $descripcion = 'description';
    private $precio = 'price';

    public function __construct(){
        $db = new DbModel();
        $this -> db = $db->sqlPDO;
        $this -> response = new Response();
        }
    
    
}