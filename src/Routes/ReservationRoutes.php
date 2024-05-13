<?php
use App\Controllers\ReservationController;

//El id es un dato sensible por eso se manda por POST
$app->post('/ver-reservaciones', ReservationController::class.':getReservations'); 
$app->post('/nueva-reservacion', ReservationController::class.':newReservations'); 
$app->delete('/eliminar-reservacion', ReservationController::class.':deleteReservations');