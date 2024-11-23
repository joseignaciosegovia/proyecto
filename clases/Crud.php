<?php 
    require_once "Conexion.inc.php";

    class Crud extends Conexion {

        public function añadirDatos($coleccion, $datos, $opciones) {
            try {
                $conexion = parent::conectar();
                $resultado = $conexion->$coleccion->insertOne($datos, $opciones);

                return $resultado;
            } catch(\Throwable $th) {
                return $th->getMessage();
            }
        }
        public function listarDatos($coleccion) {
            try {
                $conexion = parent::conectar();
                $datos = $conexion->$coleccion->find();

                return $datos;
            } catch(\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function obtenerDatos($coleccion, $consulta, $opciones) {
            try {
                $conexion = parent::conectar();
                /*$datos = $conexion->$coleccion->findOne(
                    ['_id' => new MongoDB\BSON\ObjectId($id)]
                );*/
                $datos = $conexion->$coleccion->findOne($consulta, $opciones);

                return $datos;
            } catch(\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function actualizarDatos($coleccion, $consulta, $datos) {
            try {
                $conexion = parent::conectar();
                $resultado = $conexion->$coleccion->updateOne(
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
                $conexion = parent::conectar();
                $resultado = $conexion->$coleccion->deleteOne(
                    ['_id' => new MongoDB\BSON\ObjectId($id)]
                );

                return $resultado;
            } catch(\Throwable $th) {
                return $th->getMessage();
            }
        }
    }
?>