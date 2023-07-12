<?php
    class Connection{
        public static function connect(){
            define("serverName","localhost");
            define("dbName","base2");
            define("dbUser","root");
            define("dbPassword","");

            $preferences = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");

            try{
                $connection = new PDO("mysql:host=".serverName."; dbname=".dbName,dbUser,dbPassword,$preferences);
                return $connection;
            }catch(Exception $e){
                die("Error al Intentar Establecer Conexión la Base de Datos: " .$e->getMessage());
            }
        }
    }
?>