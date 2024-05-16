<?php
use App\Controllers\UserController;

$app->get('/ver-usuarios', UserController::class . ':getUsers');
$app->post('/crear-usuario', UserController::class . ':createUser');
$app->post('/login', UserController::class . ':authenticateUser');
$app->options('/login', UserController::class . ':authenticateUser');
$app->put('/actualizar-usuario', UserController::class . ':updateUser');
$app->delete('/eliminar-usuario', UserController::class . ':deleteUser');