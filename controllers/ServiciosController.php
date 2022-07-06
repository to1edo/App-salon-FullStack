<?php

namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServiciosController {

    public static function index (Router $router){

        if(!isset($_SESSION)){
            session_start();
        }
        isAdmin();

        $servicios = Servicio::all();

        $router->render('/servicios/index',[
            'servicios' => $servicios
        ]);
    }

    public static function crear(Router $router){

        if(!isset($_SESSION)){
            session_start();
        }
        isAdmin();

        $servicio = new Servicio();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();

            if(empty($alertas)){
                
                $resultado = $servicio->guardar();

                if($resultado){
                    header('Location: /servicios');
                }
            }

        }

        $alertas = Servicio::getAlertas();
        
        $router->render('servicios/crear',[
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    public static function actualizar(Router $router){

        if(!isset($_SESSION)){
            session_start();
        }
        isAdmin();

        if($_SERVER['REQUEST_METHOD'] === 'GET'){
            $id = $_GET['id'];
            $alertas = [];
    
            if(filter_var($id,FILTER_VALIDATE_INT)){
                $servicio = Servicio::find($id);
            }

            if(!$servicio){
                header('Location: /servicios');
            }
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $servicio = new Servicio($_POST);

            $alertas = $servicio->validar();

            if(empty($alertas)){
                $servicio->guardar(); 
                header('Location: /servicios');
            }
        }

        $alertas = Servicio::getAlertas();

        $router->render('servicios/actualizar',[
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

     public static function eliminar(){

        if(!isset($_SESSION)){
            session_start();
        }
        isAdmin();
        
        if($_SERVER['REQUEST_METHOD'] === 'POST');
        {
            $id = $_POST['id'];
            
            if(filter_var($id,FILTER_VALIDATE_INT)){
                $servicio = Servicio::find($id);
            }

            if($servicio){
                $servicio->eliminar();
                header('Location: /servicios');
            }

            header('Location:'.$_SERVER['HTTP_REFERER']);
        }
    }
}