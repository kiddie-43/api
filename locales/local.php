<?php
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/helpers.inc.php';

$id_local = (isset($_GET['id_local'])) ? (html($_GET['id_local'])) : 0;

try {


    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';

    $query = "SELECT id_local, direccion, nombre_local, descripcion FROM locales where id_local = :id";

    
    $result = $pdo->prepare($query);
    $result->bindValue(":id", $id_local);
    $result->execute();
} catch (PDOException $e) {

    $error = 'Unable to connect to the database server.';
}

foreach ($result as $row) {
    $datos = array(
        'id_local'  => $row['id_local'],
        'direccion' =>   $row['direccion'],
        'nombre_local' =>   $row['nombre_local'],
        'descripcion' =>   $row['descripcion'],
        'carrusel' => carruselImagenes( $row['id_local'] )
    );
}


echo json_encode($datos);
