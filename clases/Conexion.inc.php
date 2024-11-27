<?php 
    require __DIR__ . '/../vendor/autoload.php';

    class Conexion {
        public static function conectar($usuario = "mongoadmin", $contraseña = "123456"){
            try {
                $host = "127.0.0.1";
                $puerto = "27017";
                // 'rawurlencode' evita que caracteres literales sean interpretados como delimitadores de URL
                //$usuario = rawurlencode("mongoadmin");
                //$pass = rawurlencode("123456");
                $nombreBD = "tienda";
                $cadenaConexion = sprintf("mongodb://%s:%s@%s:%s/%s", rawurlencode($usuario), rawurlencode($contraseña), $host, $puerto, $nombreBD);
                $cliente = new MongoDB\Client($cadenaConexion);
                return $cliente->selectDatabase($nombreBD);
            }catch (\Throwable $th){
                return $th->getMessage();
            }
        }
    }
    

?>