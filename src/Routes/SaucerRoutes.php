<?php
use App\Controllers\SaucerController;

//El id es un dato sensible por eso se manda por POST
$app->post('/nuevo-platillo', SaucerController::class.':newSaucer'); 
$app->get('/ver-platillos', SaucerController::class.':getSaucers'); 
$app->delete('/eliminar-platillo', SaucerController::class.':deleteSaucer');