<?php 

require_once __DIR__ . '/../includes/app.php';
$consulta = obtener_servicios();

use MVC\Router;
$router = new Router();




// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();