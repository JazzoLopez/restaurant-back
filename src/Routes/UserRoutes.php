<?php
use App\Controllers\UserController;

// Ruta para ver usuarios 
$app->get('/ver-usuarios', UserController::class . ':verUsuarios');

// Ruta para crear un nuevo usuario
$app->post('/crear-usuario', UserController::class . ':createUser');

// Ruta para eliminar un usuario por su ID 
$app->delete('/eliminar-usuario/{id}', UserController::class . ':eliminarUsuario');


//verificando si en el login manda el JWT
$app->post('/login', UserController::class.':authenticateUser');