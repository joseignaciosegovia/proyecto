<?php 
    require_once "Conexion.inc.php";

    class Crud extends Conexion {

        public function añadirDatos($coleccion, $datos) {
            try {
                $conexion = parent::conectar();
                $resultado = $conexion->$coleccion;
                $resultado = $resultado->insertOne($datos);

            } catch(\Throwable $th) {
                return $th->getMessage();
            }
        }
        public function listarDatos($coleccion) {
            try {
                $conexion = parent::conectar();
                $resultado = $conexion->$coleccion;
                $datos = $resultado->find();

                return $datos;
            } catch(\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function obtenerDatos($coleccion, $id) {
            try {
                $conexion = parent::conectar();
                $resultado = $conexion->$coleccion;
                $datos = $resultado->findOne(
                    array('_id' => new MongoDB\BSON\ObjectId($id))
                );

                return $datos;
            } catch(\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function actualizarDatos($coleccion, $id, $datos) {
            try {
                $conexion = parent::conectar();
                $resultado = $conexion->$coleccion;
                $respuesta = $resultado->updateOne(
                    ['_id' => new MongoDB\BSON\ObjectId($id)],
                    [
                        '$set' => $datos
                    ]
                );

                return $respuesta;
            } catch(\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function eliminarDatos($coleccion, $id) {
            try {
                $conexion = parent::conectar();
                $resultado = $conexion->$coleccion;
                $respuesta = $resultado->deleteOne(
                    array('_id' => new MongoDB\BSON\ObjectId($id))
                );

                return $respuesta;
            } catch(\Throwable $th) {
                return $th->getMessage();
            }
        }
    }
?>