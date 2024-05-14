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
    private $id = 'id';
    private $name = 'name';
    private $lastName = 'lastname';
    private $email = 'email';
    private $password = 'password';
    private $tel = 'tel';   

    private static $minutes = 172800;
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
            $time = time();
            $payload = [
                "user_id" => $user['id'],
                "email" => $user['email'],
                "iat"=>$time,
                'exp' => $time+3600,
            ];

            // Generar el token JWT
            $token = JWT::encode($payload, $_ENV['JWT_SECRET'], "HS256", null, [
                'kid' => $user['id'],
            ]);
            
            $this->response->result = $token;
            return $this->response->SetResponse(true, "Inicio de sesión correcto.");
        } else {
            return $this->response->SetResponse(false, "Contraseña incorrecta.");
        }
    }

    public function updateUser ($body){

    }
}