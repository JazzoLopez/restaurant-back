<?php
use App\Controladores\ReservacionControlador;

//El id es un dato sensible por eso se manda por POST
$app->post('/ver-reservaciones', ReservacionControlador::class.':verReservaciones'); 
$app->post('/nueva-reservacion', ReservacionControlador::class.':nuevaReservacion'); 
$app->delete('/eliminar-reservacion', ReservacionControlador::class.':eliminarReservacion');