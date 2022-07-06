<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\AdminController;
use Controllers\APIController;
use MVC\Router;
use Controllers\CitaController;
use Controllers\LoginController;
use Controllers\ServiciosController;

$router = new Router();

//-----------area publica-------------//

// iniciar sesion
$router->get('/',[LoginController::class,'login']);
$router->post('/',[LoginController::class,'login']);
$router->get('/logout',[LoginController::class,'logout']);

//recuperar password
$router->get('/olvide',[LoginController::class,'olvide']);
$router->post('/olvide',[LoginController::class,'olvide']);
$router->get('/recuperar',[LoginController::class,'recuperar']);
$router->post('/recuperar',[LoginController::class,'recuperar']);

//crear cuenta
$router->get('/crear-cuenta',[LoginController::class,'crear']);
$router->post('/crear-cuenta',[LoginController::class,'crear']);

//confirmar cuenta
$router->get('/confirmar-cuenta',[LoginController::class,'confirmar']);
$router->get('/mensaje',[LoginController::class,'mensaje']);


//-----------area privada-------------//

$router->get('/citas',[CitaController::class,'index']);
$router->get('/admin', [AdminController::class, 'index']);
$router->post('/admin', [AdminController::class, 'index']);

// API para servicios

$router->get('/api/servicios',[APIController::class,'index']);
$router->post('/api/citas',[APIController::class,'guardar']);
$router->post('/api/eliminar',[APIController::class,'eliminar']);

//CRUD para servicios

$router->get('/servicios',[ServiciosController::class,'index']);
$router->get('/servicios/crear',[ServiciosController::class,'crear']);
$router->post('/servicios/crear',[ServiciosController::class,'crear']);
$router->get('/servicios/actualizar',[ServiciosController::class,'actualizar']);
$router->post('/servicios/actualizar',[ServiciosController::class,'actualizar']);
$router->post('/servicios/eliminar',[ServiciosController::class,'eliminar']);
// debuguear(ServiciosController::class);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();