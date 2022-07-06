<?php

namespace Controllers;

use Classes\Email;
use MVC\Router;
use Model\Usuario;

class LoginController{

    public static function login(Router $router){

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarLogin();

            if(empty($alertas)){
                $resultado = Usuario::where('email', $usuario->email );
                
                if(empty($resultado)){
                    Usuario::setAlerta('error','Email no valido');
                }else{
                    $auth = $usuario->passwordAndConfirmado($resultado);

                    if($auth){
                        session_start();

                        $_SESSION['id'] = $resultado->id;
                        $_SESSION['nombre'] =$resultado->nombre .' '. $resultado->apellido;
                        $_SESSION['email'] = $resultado->email;
                        $_SESSION['login'] = true;
                        //redireccionar

                        if($resultado->admin === '1'){
                            $_SESSION['admin'] = $usuario->admin ?? NULL; 
                            header('Location: /admin');
                        }else{
                            header('Location: /citas');
                        }
                    }
                }
            }
        }
        $alertas = Usuario::getAlertas();

        $router->render('auth/login',[
            'alertas' => $alertas
        ]);
    }

    public static function logout(){

        session_start();
        
        $_SESSION = [];
        header('Location: /');
    }

    public static function olvide(Router $router){

        $alertas = [];
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $usuario = new Usuario($_POST);

            $alertas = $usuario->validarEmail();
            
            if(empty($alertas)){

                $resultado = Usuario::where('email',$usuario->email);

                if($resultado && $resultado->confirmado === '1'){
                    //crear token
                    $resultado->crearToken();

                    //Actalizaren la BD
                    $resultado->guardar();

                    //enviar email
                    $email = new Email($resultado->email,$resultado->nombre,$resultado->token);
                    $email->enviarRestablecer();

                    Usuario::setAlerta('exito','Revisa el email que te hemos enviado');

                }else{
                    Usuario::setAlerta('error','El Email no es valido o no esta confirmado');
                }
            }

        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/olvide',[
            'alertas' => $alertas
        ]);
    }

    public static function recuperar(Router $router){

        $alertas =[];
        $error = false;

        $token = s($_GET['token']);
        
        $resultado = Usuario::where('token',$token);

        if(!$resultado){
            Usuario::setAlerta('error','Token no valido');
            $error = true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarPassword();

            if(empty($alertas)){
                //restablecer el password
                $resultado->password = $usuario->password;
                $resultado->hashPassword();
                $resultado->token = '0';
                
                //acutlizar en la BD
                $resultado->guardar();

                Usuario::setAlerta('exito','El password fue restablecido');
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/recuperar',[
            'alertas' => $alertas,
            'error' => $error
        ]);
    }

    public static function crear(Router $router){

        $usuario = new Usuario; 

        $alertas = $usuario->getAlertas();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $usuario->sincronizar($_POST);

            $alertas = $usuario->validarNuevaCuenta();
            
            if(empty($alertas)){

                $resultado = $usuario->existeUsuario();
                
                if($resultado->num_rows){
                    $alertas = Usuario::getAlertas();
                }else{
                    //hashear password
                    $usuario->hashPassword();

                    //Generar token para el usuario
                    $usuario->crearToken();

                    //enviar el email para confirmar la cuenta
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();

                    //guardar en DB
                    $resultado = $usuario->guardar();

                    if($resultado)
                    {
                        header('Location: /mensaje');
                    }
                }
            }
        }
        
        $router->render('auth/crear-cuenta',[
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }


    public static function mensaje(Router $router){
        $router->render('auth/mensaje',[
        ]);
    }


    public static function confirmar(Router $router){
        $alertas = [];

        $token = s($_GET['token']);
        
        $usuario = Usuario::where('token',$token );
        
        if(empty($usuario)){
            Usuario::setAlerta('error','Token no valido');
        }else{
            $usuario->confirmado = 1;
            $usuario->token = 0;
            $usuario->guardar();
            Usuario::setAlerta('exito','Cuenta confiramada, ya puedes iniciar sesion');
        }
        $alertas = Usuario::getAlertas();

        $router->render('auth/confirmar-cuenta',[
            'alertas' => $alertas
        ]);
    }
}
