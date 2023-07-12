<?php

    include_once('../Model/connection.php');

    $connectedInstance = Connection::connect();

    $newCedula = $_POST['txtCedula'];

    $sql = "SELECT COUNT(CEDULA) CONTEO FROM PERSONAS WHERE CEDULA='$newCedula'";

    $preparedStatement = $connectedInstance->prepare($sql);
    if(!$preparedStatement->execute()){
        die("Error en la operación SELECT");
    }
    $answer = $preparedStatement->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($answer);
?>