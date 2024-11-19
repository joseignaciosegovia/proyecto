<?php 
    require_once "Conexion.inc.php";

    class Crud extends Conexion {

        public function añadirDatos($coleccion, $datos) {
            try {
                $conexion = parent::conectar();
                $resultado = $conexion->$coleccion->insertOne($datos);

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

        public function obtenerDatos($coleccion, $id) {
            try {
                $conexion = parent::conectar();
                $datos = $conexion->$coleccion->findOne(
                    ['_id' => new MongoDB\BSON\ObjectId($id)]
                );

                return $datos;
            } catch(\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function actualizarDatos($coleccion, $id, $datos) {
            try {
                $conexion = parent::conectar();
                $resultado = $conexion->$coleccion->updateOne(
                    ['_id' => new MongoDB\BSON\ObjectId($id)],
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