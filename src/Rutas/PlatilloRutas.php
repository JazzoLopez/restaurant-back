<?php
use App\Controladores\PlatilloControlador;

//El id es un dato sensible por eso se manda por POST
$app->post('/nuevo-platillo', PlatilloControlador::class.':nuevoPlatillo'); 
$app->get('/ver-platillos', PlatilloControlador::class.':verPlatillos'); 
$app->delete('/eliminar-platillo', PlatilloControlador::class.':eliminarPlatillo');