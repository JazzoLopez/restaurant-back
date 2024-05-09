<?php
use App\Controladores\CreateUserController;

// Ruta para ver usuarios 
$app->get('/ver-usuarios', CreateUserController::class . ':verUsuarios');

// Ruta para crear un nuevo usuario
$app->post('/crear-usuario', CreateUserController::class . ':crearUsuario');

// Ruta para eliminar un usuario por su ID 
$app->delete('/eliminar-usuario/{id}', CreateUserController::class . ':eliminarUsuario');
