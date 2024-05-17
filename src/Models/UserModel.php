<?php
namespace App\Models;

use App\Models\DbModel;
use App\Lib\Response;
use App\Lib\Mailer;
use App\Lib\tokens;
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
    private $userToken = 'token';
    private $token;
    private $Mailer;

    public function __construct()
    {
        $db = new DbModel();
        $this->db = $db->sqlPDO;
        $this->response = new Response();
        $this->Mailer = new Mailer();
        $this->token = new tokens();

    }

    public function createUser($userData)
    {

        if (empty($userData->name) || empty($userData->lastname) || empty($userData->tel) || empty($userData->email) || empty($userData->password)) {
            return $this->response->SetResponse(false, "Por favor, rellene todos los campos.");
        }
        if (!filter_var($userData->email, FILTER_VALIDATE_EMAIL)) {
            return $this->response->SetResponse(false, "Correo electrónico no válido.");
        }
        $existingUser = $this->db->from($this->tbUsers)->where($this->email, $userData->email)->count();
        if ($existingUser > 0) {
            return $this->response->SetResponse(false, "El correo electrónico ya está registrado.");
        }
        $token = $this->token->generateToken();
        $data = [
            $this->name => $userData->name,
            $this->lastName => $userData->lastname,
            $this->tel => $userData->tel,
            $this->email => $userData->email,
            $this->password => password_hash($userData->password, PASSWORD_DEFAULT),
            $this ->userToken => $token

        ];

        $result = $this->db->insertInto($this->tbUsers)->values($data)->execute();
        if (!$result) {
            return $this->response->SetResponse(false, "Error al crear el usuario");
        }
        
        $this->Mailer->sendMail($userData->email,'Verificacion de la cuenta',$userData,$data['token']);
        return $this->response->SetResponse(true, "Usuario registrado, Se envio un correo para activar tu cuenta.");

    }

    public function authenticateUser($body)
    {
        if (empty($body->email) || empty($body->password)) {
            return $this->response->SetResponse(false, "Por favor, rellene todos los campos.");
        }
        if (!filter_var($body->email, FILTER_VALIDATE_EMAIL)) {
            return $this->response->SetResponse(false, "Correo electrónico no válido.");
        }
        $password = $body->password;
        $user = $this->db->from($this->tbUsers)->where($this->email, $body->email)->fetch();

        if (!$user) {
            return $this->response->SetResponse(false, "Usuario no encontrado.");
        }
        if($user['status'] == 0){
            return $this->response->SetResponse(false, "Por favor, verifica tu cuenta.");
        }
        // Verificar la contraseña
        if (password_verify($password, $user['password'])) {
            $this->response->result = $user;
            return $this->response->SetResponse(true, "Inicio de sesión correcto.");
        } else {
            return $this->response->SetResponse(false, "Contraseña incorrecta.");
        }
    }

    public function updateUser($body)
    {
        if (empty($body->name) || empty($body->lastname) || empty($body->tel) || empty($body->email) || empty($body->password)) {
            return $this->response->SetResponse(false, "Por favor, rellene todos los campos.");
        }
        if (!filter_var($body->email, FILTER_VALIDATE_EMAIL)) {
            return $this->response->SetResponse(false, "Correo electrónico no válido.");
        }
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

    public function verifyAccount($token)
    {   
        $isTokenExist = $this->db->from($this ->tbUsers)->where('token', $token)->fetch();
        if (!$isTokenExist) {
            return $this->response->SetResponse(false, 'El token expiro.');
        }
        $data = $this->db->update($this->tbUsers)->set('status', 1)->set('token', null)->where('token', $token)->execute();
        if ($data) {
            return $this->response->SetResponse(true, 'Cuenta verificada.');
        } else {
            return $this->response->SetResponse(false, 'Error al verificar la cuenta, revisa tu token.');
        }
    }
}