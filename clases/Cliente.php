<?php
require_once __DIR__ . "/Conexion.inc.php";
class Cliente extends Conexion {
    private $usuario;
    private $contraseña;
    private $nombreCompleto;
    private $localidad;
    private $direccion;
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
                $this->localidad = func_get_arg(3);
                $this->direccion = func_get_arg(4);
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
    public static function isValido($usuario, $contraseña) {
        try {
            $conexion = parent::conectar();
            $consulta = [
                "usuario" => $usuario
            ];
            // Obtenemos la contraseña del documento que tiene el nombre de usuario del cliente introducido
            $resultado = $conexion->contraseñasCl->findOne($consulta, []);

            // Si se ha encontrado un usuario
            if($resultado) {
                // Comprobamos que la contraseña es correcta
                if(password_verify($contraseña, $resultado->contraseña)) {
                    // Buscamos el cliente de la colección de clientes
                    $consulta = [
                        "_id" => $resultado->cliente_id
                    ];
                    $resultado = $conexion->clientes->findOne($consulta, []);
                }
                // Si la contraseña es incorrecta
                else {
                    return null;
                }
            }
            // Si no se ha encontrado un usuario
            else{
                return null;
            }
            
        } catch(\Throwable $th) {
            return $th->getMessage();
        }

        // Devolvemos los datos del cliente
        return $resultado;
    }
}
