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

    public function getReservations($userId)
    {

        $resutl = $this->db->from($this->tbReservaciones)->where($this->userID, $userId)->fetchAll();
        if (count($resutl) > 0) {
            $this->response->result = $resutl;
            return $this->response->SetResponse(true, "Datos pintados correctamente");
        } else {
            return $this->response->SetResponse(false, "El Id del usuario no existe");
        }
    }

    public function deleteReservations($body)
    {
        $id = $body->id;
        $validate = $this->db->delete($this->tbReservaciones)->where($this->id, $id)->execute();
        if ($validate > 0) {
            return $this->response->SetResponse(true, 'Reservacion eliminada correctamente');
        } else {
            return $this->response->SetResponse(false, 'Error al eliminar');
        }
    }

    public function newReservations($body, $userId)
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
            'user_id' => $userId
        ];
        $result = $this->db->insertInto($this->tbReservaciones)->values($data)->execute();
        if (!$result) {
            return $this->response->SetResponse(false, '');
        }
        //$this -> response -> result = $result;
        return $this->response->SetResponse(true, 'Reservación guardada correctamente');
    }

}