<?php 
    require_once "Conexion.inc.php";

    class Crud extends Conexion {
        private $conexion;

        public function __construct($usuario = "mongoadmin", $contraseña = "123456") {
            $this->conexion = parent::conectar($usuario, $contraseña);
        }

        public function añadirDatos($coleccion, $datos, $opciones) {
            try {
                //$conexion = parent::conectar();
                $resultado = $this->conexion->$coleccion->insertOne($datos, $opciones);

                return $resultado;
            } catch(\Throwable $th) {
                return $th->getMessage();
            }
        }
        public function listarDatos($coleccion, $consulta, $opciones) {
            try {
                //$conexion = parent::conectar();
                $datos = $this->conexion->$coleccion->find($consulta, $opciones);

                return $datos;
            } catch(\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function obtenerDatos($coleccion, $consulta, $opciones) {
            try {
                //$conexion = parent::conectar();
                $datos = $this->conexion->$coleccion->findOne($consulta, $opciones);

                return $datos;
            } catch(\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function actualizarDatos($coleccion, $consulta, $datos) {
            try {
                //$conexion = parent::conectar();
                $resultado = $this->conexion->$coleccion->updateOne(
                    $consulta,
                    [
                        '$set' => $datos
                    ]
                );

                return $resultado;
            } catch(\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function eliminarDatos($coleccion, $id) {
            try {
                //$conexion = parent::conectar();
                $resultado = $this->conexion->$coleccion->deleteOne(
                    ['_id' => new MongoDB\BSON\ObjectId($id)]
                );

                return $resultado;
            } catch(\Throwable $th) {
                return $th->getMessage();
            }
        }
    }
?>