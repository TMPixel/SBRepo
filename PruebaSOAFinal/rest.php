<?php
    header("Content-Type: application/json");
    require_once('buscar.php');

    $serverMethod = $_SERVER['REQUEST_METHOD'];

    switch($serverMethod){
        case 'GET':
            Buscar::buscarPorCurso();
            break;
    }
?>