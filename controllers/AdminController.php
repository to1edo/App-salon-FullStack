<?php

namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController{

    public static function index(Router $router){

        if(!isset($_SESSION)){
            session_start();
        }
        isAdmin();
     
        $fecha = date('Y-m-d');
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $fecha = $_POST['fecha'];
            $fechas = explode('-',$fecha);


            if( !checkdate($fechas[1],$fechas[2],$fechas[0])){
                header('Location: /admin');
            }
        }

        $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuarioId=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citasServicios ";
        $consulta .= " ON citasServicios.citaId=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citasServicios.servicioId ";
        $consulta .= " WHERE fecha =  '${fecha}' ";

        $citas = AdminCita::SQL($consulta);
        
        $mensaje = '';

        if(empty($citas)){
            $mensaje = 'No hay citas para la fecha seleccionada';
        };

        $router->render('admin/index',[
            'citas'=> $citas,
            'fecha' => $fecha,
            'mensaje' => $mensaje
        ]);
    }
}