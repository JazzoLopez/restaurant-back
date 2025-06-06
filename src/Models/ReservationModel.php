<?php
namespace App\Models;

use App\Models\DbModel,
App\Lib\Response;
use Firebase\JWT\JWT;

class ReservationModel
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

    public function getReservations($body)
    {if(empty($body->userID)){
        return $this->response->setResponse(false, 'El id del usuario es requerido.');
    }

        $resutl = $this->db->from($this->tbReservaciones)->where($this->userID, $body->userID)->fetchAll();
        if (count($resutl) > 0) {
            $this->response->result = $resutl;
            return $this->response->SetResponse(true, "Datos pintados correctamente");
        } else {

            return $this->response->SetResponse(false, "El Id del usuario no existe");
        }
    }

    public function deleteReservations($body)
    {
        if(empty($body->userID)){
            return $this->response->SetResponse(false, 'El id del usuario es requerido.');
        }
        $isExist = $this->db->from($this->tbReservaciones)->where($this->id, $body->id);
        if ($isExist->count() == 0) {
            return $this->response->SetResponse(false, 'La reservación no existe');
        }
        $validate = $this->db->delete($this->tbReservaciones)->where($this->id, $body->id)->where($this->userID, $body->userID)->execute();
        if ($validate > 0) {
            return $this->response->SetResponse(true, 'Reservacion eliminada correctamente');
        } else {
            return $this->response->SetResponse(false, 'Error al eliminar');
        }
    }

    public function newReservations($body)
    {
        if(empty($body->date) || empty($body->hour) || empty($body->quantity) || empty($body->comments) || empty($body->status) || empty($body->user_id))
            return $this->response->SetResponse(false, 'Campos requeridos');
        $isUserExist = $this->db->from($this->tbReservaciones)->where($this->userID, $body->user_id);
        if (!$isUserExist) {
            return $this->response->SetResponse(false, "El usuario no existe.");
        }
        $validate = $this->db->from($this->tbReservaciones)
            ->where($this->hour, $body->hour)->where($this->date, $body->date)->count();
        if ($validate > 0) {
            return $this->response->SetResponse(false, "La hora de reservación ya esta ocupada");
        }
        $data = [
            'date' => $body->date,
            'hour' => $body->hour,
            'quantity' => $body->quantity,
            'comments' => $body->comments,
            'status' => $body->status,
            'user_id' => $body->user_id
        ];
        $result = $this->db->insertInto($this->tbReservaciones)->values($data)->execute();
        if (!$result) {
            return $this->response->SetResponse(false, '');
        }
        return $this->response->SetResponse(true, 'Reservación guardada correctamente');
    }

}