<?php
use App\Controladores\ReservacionControlador;


$app->get('/ver-reservaciones/{userID}', ReservacionControlador::class.':verReservaciones'); 
$app->post('/nueva-reservacion', ReservacionControlador::class.':nuevaReservacion'); 