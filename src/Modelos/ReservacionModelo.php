<?php
namespace App\Modelos;

use App\Modelos\DbModel,
App\Lib\Response;
use Firebase\JWT\JWT;


class ReservacionModelos
{
    private $response;
    private $tbReservaciones = 'reservations';
    private $id = 'id';
    private $db = null;
    private $date = 'date';
    private $hour = 'hour';
    private $comments = 'comments';
    private $userID = 'user_id';

    public function __construct()
    {
        $db = new DbModel();
        $this->db = $db->sqlPDO;
        $this->response = new Response();
    }

    public function verReservaciones($body)
    {
        $jwt = $body -> jwt;
        $decodedToken = JWT::decode($jwt, $_ENV['JWT_SECRET'], []);

    // Acceder a los datos decodificados
        $userId = $decodedToken->user_id;
        $email = $decodedToken->email;

        $resutl = $this->db->from($this->tbReservaciones)->where($this -> userID, $userId)->fetchAll();
        if (count($resutl) > 0) {
            $this->response->result = $resutl;
            return $this->response->SetResponse(true, "Datos pintados correctamente");
        } else {
            return $this->response->SetResponse(false, "El Id de la reservación no existe");
        }
    }

    public function eliminarReservacion($body)
    {
        $id = $body -> id;
        $validate = $this->db->delete($this->tbReservaciones)->where($this -> id, $id)->execute();
        if ($validate > 0) {
            return $this->response->SetResponse(true, 'Reservacion eliminada correctamente');
        } else {
            return $this->response->SetResponse(false, 'Error al eliminar');
        }
    }

    public function nuevaReservacion($body)
    {
        $validate = $this->db->from($this->tbReservaciones)
            ->where($this->hour, $body->hour)->where($this->date, $body->date)->count();
        if ($validate > 0) {
            return $this->response->SetResponse(false, "La hora de reservación ya esta ocupada");
        }
        $data = [
            'date' => $body->date,
            'hour' => $body->hour,
            'comments' => $body->comments,
            'user_id' => $body->user_id
        ];
        $result = $this->db->insertInto($this->tbReservaciones)->values($data)->execute();
        if (!$result) {
            return $this->response->SetResponse(false, '');
        }
        //$this -> response -> result = $result;
        return $this->response->SetResponse(true, 'Reservación guardada correctamente');
    }

}