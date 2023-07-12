<?php
    header("Content-Type: application/json");
    require_once('../ModelSpringboot/personDataAccess.php');

    $serverMethod = $_SERVER['REQUEST_METHOD'];

    switch($serverMethod){
        case 'GET':
            CRUDPerson::readPersons();
            break;
        case 'POST':
            CRUDPerson::insertPerson();
            break;
        case 'PUT':
            CRUDPerson::updatePerson();
            break;
        case 'DELETE':
            CRUDPerson::deletePerson();
            break;
    }
?>