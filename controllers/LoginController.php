<?php

namespace Controllers;

use MVC\Router;
use Model\Usuario;
use Classes\Email;

class LoginController {
    public static function login(Router $router) {
        $alertas = [];
        $auth = new Usuario;
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();
            if(empty($alertas)){
                //comprobar que exista usuario
                $usuario = Usuario::where('email', $auth->email);

                if($usuario){
                    //Verificar el password
                    //debuguear($usuario);
                    if ($usuario->comprobarPasswordAndVerificado($auth->password)) {
                        // Autenticar el usuario
                        session_start();

                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        // Redireccionamiento
                        if($usuario->tipoPerfil === "1") {
                            $_SESSION['tipoPerfil'] = $usuario->tipoPerfil ?? null;
                            header('Location: /admin');
                        } else {
                            header('Location: /cita');
                        }
                    }
                }else {
                    Usuario::setAlerta('error','Usuario no encontrado.');
                }
            }
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/login', [
            'alertas' => $alertas,
            'auth' => $auth
        ]);
    }

    public static function logout() {
        echo "Cerrar sesión";
    }

    public static function olvide(Router $router) {

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if(empty($alertas)) {
                 $usuario = Usuario::where('email', $auth->email);

                 if($usuario && $usuario->confirmado === "1") {
                        
                    // Generar un token
                    $usuario->crearToken();
                    $usuario->guardar();

                    //  Enviar el email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    // Alerta de exito
                    Usuario::setAlerta('exito', 'Revisa tu email');
                 } else {
                    Usuario::setAlerta('error', 'El Usuario no existe o no esta confirmado');
                     
                 }
            } 
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/olvide', [
            'alertas' => $alertas
        ]);
    }

    public static function recuperar(Router $router) {
        $alertas = [];
        $error = false;

        $token = s($_GET['token']);

        // Buscar usuario por su token
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)) {
            Usuario::setAlerta('error', 'Token No Válido');
            $error = true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Leer el nuevo password y guardarlo

            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();

            if(empty($alertas)) {
                $usuario->password = null;

                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;

                $resultado = $usuario->guardar();
                if($resultado) {
                    header('Location: /');
                }
            }
        }
        

        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar', [
            'alertas' => $alertas,
            'error' => $error
        ]);
    }
    public static function crear(Router $router) {
        //crear instancia
        $usuario = new Usuario;

        //Alertas vacias
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            //debuguear($alertas);

            //Revisar que alerta este vacio
            if(empty($alertas)) {
                //Verificar que el usuario no este regitrado por email
                $resultado = $usuario->existeUsuario();

                if($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {
                    //Hashear el Password
                    $usuario->hashPassword();

                    //General un tokens unico
                    $usuario->crearToken();

                    //Enviar email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();

                    //Crear el usuario
                    $resultado = $usuario->guardar();
                    if($resultado){
                        header('Location: /mensaje');
                    }

                    //debuguear($usuario);
                }
            }
        }

        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);

    }
    public static function mensaje(Router $router) {
        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router) {
        $alertas = [];
        //sanetizo el token y envio el token 
        $token = s($_GET['token']);
        //pruebo ver el token
        //debuguear($token);

        //metodo activeREcord
        $usuario = Usuario::where('token', $token);
        //pruebo si ebusca por token
        //debuguear($usuario);

        if(empty($usuario)) {
            //Mostrar mensaje de error
            Usuario::setAlerta('error','Token no Válido');
            //echo "token no valido";
        } else {
            //cambiar valor de columna confirmado a 1
            $usuario->confirmado = "1";
            $usuario->token=null;
            $usuario->guardar();
            //echo "token valido";
            Usuario::setAlerta('exito','Cuenta confirmada conrrectamente');
        }
        //obtener las alertas
        $alertas = Usuario::getAlertas();

        //renderizar la vista
        $router->render('auth/confirmar-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
        
    }
}