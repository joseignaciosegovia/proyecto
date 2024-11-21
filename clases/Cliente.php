<?php
require_once __DIR__ . "/Conexion.inc.php";
class Cliente extends Conexion {
    private $usuario;
    private $contraseña;
    private $nombreCompleto;
    private $direccion;
    private $ciudad;
    private $email;
    private $telefono;
    private $compras;
    private $deseos;
    private $quejas;

    public function __construct() {
        $num = func_num_args(); //guardamos el número de argumentos
        switch ($num) {
            // Constructor vacío
            case 0:
                break;
            // Constructor con argumentos
            case 7:
                $this->usuario = func_get_arg(0);
                $this->contraseña = func_get_arg(1);
                $this->nombreCompleto = func_get_arg(2);
                $this->direccion = func_get_arg(3);
                $this->ciudad = func_get_arg(4);
                $this->email = func_get_arg(5);
                $this->telefono =func_get_arg(6);
                break;
        }
    }

    /*public function __construct($usuario, $contraseña, $nombreCompleto, $direccion, $ciudad, $email, $telefono) {
        $this->usuario = $usuario;
        $this->contraseña = $contraseña;
        $this->nombreCompleto = $nombreCompleto;
        $this->direccion = $direccion;
        $this->ciudad = $ciudad;
        $this->email = $email;
        $this->telefono = $telefono;

    }*/

    public function __get($property){
        if(property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value){
        if(property_exists($this, $property)) {
            $this->$property = $value;
        }
    }

    // Comprueba si el acceso ha sido correcto
    public function isValido($usuario, $contraseña) {
        try {
            $conexion = parent::conectar();
            $consulta = [
                "usuario" => $usuario,
                "contraseña" => $contraseña
            ];
            $resultado = $conexion->contraseñasClientes->findOne($consulta, []);
        } catch(\Throwable $th) {
            return $th->getMessage();
        }

        if ($resultado != null) return true;
        return false;
    }
}