<?php

namespace Model;

class Usuario extends ActiveRecord{

    //base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id','nombre','apellido','email','telefono','password','admin','confirmado','token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $telefono;
    public $password;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args =[]){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '0';
    }

    
    public function validarNuevaCuenta() {
        
        if(!$this->nombre){
            static::$alertas['error'][] = 'El nombre es obligatorio';
        }

        if(!$this->apellido){
            static::$alertas['error'][] = 'El apellido es obligatorio';
        }


        if(!$this->telefono){
            static::$alertas['error'][] = 'El telefono es obligatorio';
        }

        if(!$this->email){
            static::$alertas['error'][] = 'El email es obligatorio';
        }

        if(!$this->password){
            static::$alertas['error'][] = 'El password es obligatorio';
        }elseif(strlen($this->password)<6){
            static::$alertas['error'][] = 'El password debe tener al menos 6 caracteres';
        }


        return static::$alertas;
    }

    public function validarLogin() {

        if(!$this->email){
            static::$alertas['error'][] = 'El email es obligatorio';
        }

        if(!$this->password){
            static::$alertas['error'][] = 'El password es obligatorio';
        }elseif(strlen($this->password)<6){
            static::$alertas['error'][] = 'El password debe tener al menos 6 caracteres';
        }

        return static::$alertas;
    }

    public function validarEmail() {

        if(!$this->email){
            static::$alertas['error'][] = 'El email es obligatorio';
        }

        return static::$alertas;
    }

    public function validarPassword() {

        if(!$this->password){
            static::$alertas['error'][] = 'El password es obligatorio';
        }elseif(strlen($this->password)<6){
            static::$alertas['error'][] = 'El password debe tener al menos 6 caracteres';
        }

        return static::$alertas;
    }

    // verificar si el usuario ya esta registrado
    public function existeUsuario(){
        $query = "SELECT * FROM " . static::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        $resultado = self::$db->query($query);

        if($resultado->num_rows){
            self::$alertas['error'][] = "El correo ya se encuentra registrado";
        }

        return $resultado;
    }

    public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken(){
        $this->token = uniqid();
    }


    public function passwordAndConfirmado($resultado){

        $verifyPass = password_verify($this->password,$resultado->password);
                    
        if($verifyPass){
            if($resultado->confirmado === '1'){
                return true;
            }else{
                Usuario::setAlerta('error','Tu cuenta no ha sido confirmada, revisar tu email con las instrucciones antes de intentar iniciar sesion');
            }
        }else{
            Usuario::setAlerta('error','Password incorrecto');
        }
    }

}