<?php

namespace Model;

class Servicio extends ActiveRecord{

    //base de datos 

    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id','nombre','precio'];

    public $id;
    public $nombre;
    public $precio;

    public function __construct($args= [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? null;
        $this->precio = $args['precio'] ?? null;
    }

    public function validar() {
        
        if(!$this->nombre){
            static::$alertas['error'][] = 'El nombre es obligatorio';
        }

        if(!$this->precio){
            static::$alertas['error'][] = 'El precio es obligatorio';

            
        }elseif(!is_numeric($this->precio)){
               static::$alertas['error'][] = 'El precio no es valido';
        }
        
        
        return static::$alertas;
    }

}