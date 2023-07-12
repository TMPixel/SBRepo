<?php

include_once('connection.php');

class CRUDPerson{
    
    static $connectedInstance;

    private static function stablishConnection(){
        self::$connectedInstance = Connection::connect();
    }

    public static function readPersons(){
        self::stablishConnection();

        $sql = "SELECT cedula, nombre, apellido, edad FROM persona";

        $preparedStatement = self::$connectedInstance->prepare($sql);
        if(!$preparedStatement->execute()){
            die("Error en la operación SELECT");
        }
        $answer = $preparedStatement->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($answer);
        return;
    }
    
    public static function insertPerson(){
        self::stablishConnection();
        $serverAnswer = json_decode(file_get_contents("php://input"));
        $cedula = $serverAnswer->cedula;
        $nombre = $serverAnswer->nombre;
        $apellido = $serverAnswer->apellido;
        $edad = $serverAnswer->edad;
        
        $sql = "INSERT INTO persona(cedula, nombre, apellido, edad)".
        "VALUES('$cedula','$nombre','$apellido',$edad)";
        $preparedStatement = self::$connectedInstance->prepare($sql);
        if(!$preparedStatement->execute()){
            die("Error en la operación de Inserción");
        }
    }

    public static function updatePerson(){
        self::stablishConnection();

        $serverAnswer = json_decode(file_get_contents("php://input"));
        $cedula = $serverAnswer->cedula;
        $nombre = $serverAnswer->nombre;
        $apellido = $serverAnswer->apellido;
        $edad = $serverAnswer->edad;

        $sql = "UPDATE persona SET nombre='$nombre', apellido='$apellido', edad='$edad' WHERE cedula='$cedula'";

        $preparedStatement = self::$connectedInstance->prepare($sql);
        if(!$preparedStatement->execute()){
            die("Error en la operación de Actualización");
        }
    }

    public static function deletePerson(){
        self::stablishConnection();
        $cedula = $_GET['cedula'];
        $sql = "DELETE FROM persona WHERE cedula='$cedula'";

        $preparedStatement = self::$connectedInstance->prepare($sql);
        if(!$preparedStatement->execute()){
            die("Error en la operación de Eliminación");
        }
    }

    public static function searchPerson(){
        self::stablishConnection();
        $cedula = $_GET['cedula'];
    
        $sql = "SELECT * FROM persona ".
        "WHERE cedula LIKE '%$cedula%' ".
        "OR nombre LIKE '%$cedula%' ".
        "OR apellido LIKE '%$cedula%' ".
        "OR edad LIKE '%$cedula%' ";

        $preparedStatement = self::$connectedInstance->prepare($sql);
        if(!$preparedStatement->execute()){
            die("Error en la operación de Búsqueda");
        }
    
        $result = $preparedStatement->fetch(PDO::FETCH_ASSOC);
        echo json_encode($result);
        return;
    }
}


?>