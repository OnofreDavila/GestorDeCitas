<<<<<<< HEAD
<?php

namespace Controllers;

use MVC\Router;

class CitaController {
    public static function index( Router $router ) {

        //session_start();

        //isAuth();

        $router->render('cita/index', [
            'nombre' => $_SESSION['nombre']
            //'id' => $_SESSION['id']
        ]);
    }
=======
<?php

namespace Controllers;

use MVC\Router;

class CitaController {
    public static function index( Router $router ) {

        //session_start();

        //isAuth();

        $router->render('cita/index', [
            'nombre' => $_SESSION['nombre']
            //'id' => $_SESSION['id']
        ]);
    }
>>>>>>> e73ab30300cfd69d1106b720a967b4488360ea44
}