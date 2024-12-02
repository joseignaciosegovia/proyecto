<?php 
    require_once "../modelo/Conexion.inc.php";

    class Crud extends Conexion {
        private $conexion;

        public function __construct($usuario = "mongoadmin", $contraseña = "123456") {
            $this->conexion = parent::conectar($usuario, $contraseña);
        }

        public function añadirDatos($coleccion, $datos, $opciones) {
            try {
                $resultado = $this->conexion->$coleccion->insertOne($datos, $opciones);

                return $resultado;
            } catch(\Throwable $th) {
                return $th->getMessage();
            }
        }
        public function listarDatos($coleccion, $consulta, $opciones) {
            try {
                $datos = $this->conexion->$coleccion->find($consulta, $opciones);

                return $datos;
            } catch(\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function obtenerDatos($coleccion, $consulta, $opciones) {
            try {
                $datos = $this->conexion->$coleccion->findOne($consulta, $opciones);

                return $datos;
            } catch(\Throwable $th) {
                return $th->getMessage();
            }
        }

        public function actualizarDatos($coleccion, $consulta, $datos) {
            try {
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
                $resultado = $this->conexion->$coleccion->deleteOne(
                    ['_id' => new MongoDB\BSON\ObjectId($id)]
                );

                return $resultado;
            } catch(\Throwable $th) {
                return $th->getMessage();
            }
        }

         // Comprueba si el acceso ha sido correcto
        public static function isValido($coleccion, $usuario, $contraseña) {
            try {
                switch($coleccion) {
                    case 'clientes':
                        $coleccionContraseña = "contraseñasCl";
                        $idUsuario = "cliente_id";
                        break;
                    case 'trabajadores':
                        $coleccionContraseña = "contraseñasTr";
                        $idUsuario = "trabajador_id";
                        break;
                }

                $conexion = parent::conectar();
                $consulta = [
                    "usuario" => $usuario
                ];
                // Obtenemos la contraseña del documento que tiene el nombre de usuario introducido
                $resultado = $conexion->$coleccionContraseña->findOne($consulta, []);

                // Si se ha encontrado un usuario
                if($resultado) {
                    // Comprobamos que la contraseña es correcta
                    if(password_verify($contraseña, $resultado->contraseña)) {
                        // Buscamos el usuario de la colección correspondiente
                        $consulta = [
                            "_id" => $resultado->$idUsuario
                        ];
                        $resultado = $conexion->$coleccion->findOne($consulta, []);
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
?>