<?php
namespace App\Modelos;

use App\Modelos\DbModel;
use App\Lib\Response;

class UserModel {
    private $response;
    private $tbUsers = 'users';
    private $db = null;
    private $id = 'id';
    private $name = 'name';
    private $lastName = 'last_name';
    private $email = 'email';
    private $password = 'password';

    public function __construct(){
        $db = new DbModel();
        $this->db = $db->sqlPDO;
        $this->response = new Response();
    }

    public function getUserById($userId){ 
        $result = $this->db->from($this->tbUsers)->where($this->id, $userId)->fetch();
        $this->response->result = $result;
        return $this->response->SetResponse(true, "Usuario obtenido correctamente");
    }

    public function createUser($userData){
        // Verificar si el correo electrónico ya está registrado
        $existingUser = $this->db->from($this->tbUsers)->where($this->email, $userData->email)->count();
        if($existingUser > 0){
            return $this->response->SetResponse(false, "El correo electrónico ya está registrado");
        }

        $data = [
            $this->name => $userData->name,
            $this->lastName => $userData->lastName,
            $this->email => $userData->email,
            $this->password => password_hash($userData->password, PASSWORD_DEFAULT) // Se hashea la contraseña antes de guardarla en la base de datos
        ];

        $result = $this->db->insertInto($this->tbUsers)->values($data)->execute();
        if(!$result){
            return $this->response->SetResponse(false, "Error al crear el usuario");
        }

        return $this->response->SetResponse(true, "Usuario creado correctamente");
    }
}
