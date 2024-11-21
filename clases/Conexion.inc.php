<?php 
    require __DIR__ . '/../vendor/autoload.php';

    class Conexion {
        public function conectar(){
            try {
                $host = "127.0.0.1";
                $puerto = "27017";
                // 'rawurlencode' evita que caracteres literales sean interpretados como delimitadores de URL
                $usuario = rawurlencode("mongoadmin");
                $pass = rawurlencode("123456");
                $nombreBD = "tienda";
                # Crea algo como mongodb://parzibyte:hunter2@127.0.0.1:27017/agenda
                $cadenaConexion = sprintf("mongodb://%s:%s@%s:%s/%s", $usuario, $pass, $host, $puerto, $nombreBD);
                $cliente = new MongoDB\Client($cadenaConexion);
                return $cliente->selectDatabase($nombreBD);
            }catch (\Throwable $th){
                return $th->getMessage();
            }
        }
    }
    

?>