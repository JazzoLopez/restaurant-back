<?php
namespace App\Models;

use App\Models\DbModel;
use App\Lib\Response;
use Firebase\JWT\JWT;

class UserModel
{
    private $response;
    private $tbUsers = 'users';
    private $db = null;
    private $userID = 'id';
    private $name = 'name';
    private $lastName = 'lastname';
    private $email = 'email';
    private $password = 'password';
    private $tel = 'tel';

    public function __construct()
    {
        $db = new DbModel();
        $this->db = $db->sqlPDO;
        $this->response = new Response();
    }

    public function createUser($userData)
    {
        // Verificar si el correo electrónico ya está registrado
        $existingUser = $this->db->from($this->tbUsers)->where($this->email, $userData->email)->count();
        if ($existingUser > 0) {
            return $this->response->SetResponse(false, "El correo electrónico ya está registrado");
        }
        $data = [
            $this->name => $userData->name,
            $this->lastName => $userData->lastname,
            $this->tel => $userData->tel,
            $this->email => $userData->email,
            $this->password => password_hash($userData->password, PASSWORD_DEFAULT) // Se hashea la contraseña antes de guardarla en la base de datos
        ];

        $result = $this->db->insertInto($this->tbUsers)->values($data)->execute();
        if (!$result) {
            return $this->response->SetResponse(false, "Error al crear el usuario");
        }

        return $this->response->SetResponse(true, "Usuario creado correctamente");
    }

    public function authenticateUser($body)
    {
        $password = $body->password; // No necesitas hashear el password aquí
        $user = $this->db->from($this->tbUsers)->where($this->email, $body->email)->fetch();

        if (!$user) {
            return $this->response->SetResponse(false, "Usuario no encontrado.");
        }

        // Verificar la contraseña
        if (password_verify($password, $user['password'])) {
            $this->response->result = $user['id'];
            return $this->response->SetResponse(true, "Inicio de sesión correcto.");
        } else {
            return $this->response->SetResponse(false, "Contraseña incorrecta.");
        }
    }

    public function updateUser($body)
    {
        $data = [
            "name" => $body->name,
            "lastname" => $body->lastname,
            "tel" => $body->tel,
            "email" => $body->email,
            $this->password => password_hash($body->password, PASSWORD_DEFAULT)
        ];
        $isExist = $this->db->from($this->tbUsers)->where($this->email, $body->email)->fetch();

        if ($isExist) {
            return $this->response->SetResponse(false, 'El correo electrónico ya está registrado.');
        }

        $result = $this->db->update($this->tbUsers)->set($data)->where($this->userID, $body->id)->execute();
        if ($result) {
            $this->response->result = $result;
            return $this->response->SetResponse(true, 'Usuario actualizado.');
        } else {
            return $this->response->SetResponse(false, 'Error al actualizar.');
        }
    }

    public function deleteUser($body)
    {
        $isExist = $this->db->from($this->tbUsers)->where($this->userID, $body->id)->fetch();
        if (!$isExist) {
            return $this->response->SetResponse(false, "EL usuario no existe");
        }
        $data = $this->db->deleteFrom($this->tbUsers)->where($this->userID, $body->id)->execute();
        if ($data) {
            return $this->response->SetResponse(true, 'Usuario eliminado correctamente.');
        } else {
            return $this->response->SetResponse(false, 'Error al eliminar');
        }
    }

    public function getUsers()
    {
        $data = $this->db->from($this->tbUsers)->select($this->name)->fetchAll();
        if ($data) {
            $this->response->result = $data;
            return $this->response->SetResponse(true, 'Usuarios encontrados.');
        } else {
            return $this->response->SetResponse(false, 'No se encontraron usuarios.');
        }
    }

    public function getOne($body)
    {

    }
}