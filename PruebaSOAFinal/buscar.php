<?php
include_once("connection.php");
class Buscar{
    public static function buscarPorCurso(){
        $connection = connection::connect();
        $nom_cur = $_GET['nom_cur'];
        $query= "SELECT * FROM estudiantes est, cursos cur WHERE cur.id_cur = est.cur_per AND cur.nom_cur LIKE '%$nom_cur%'"; 
        $result = $connection->prepare($query);
        $result->execute();

        $data = $result->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($data); 
    }
}
?>