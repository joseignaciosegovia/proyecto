<?php

class Usuario extends Conexion {
    private $usuario;
    private $contraseña;

    public function __construct() {
        parent::__construct();
    }
    public function isValido($usuario, $contraseña) {
        try {
            $conexion = parent::conectar();
            $coleccion = $conexion->usuario;
            $datos = $coleccion->findOne(
                array('_id' => new MongoDB\BSON\ObjectId($id))
            );
        } catch(\Throwable $th) {
            $th->getMessage();
        }
        if ($datos) return false;
        return true;
    }
}
