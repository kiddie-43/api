<?php

// const URL_SERVER = "http://dws.local/api/";
// const URL_IMG = "img/locales/";
// const BARRA = "/";
// const URL_LOCAL = "/api/img/locales/";
// const URL = "http://dws.local/api/";

include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/helpers.inc.php';

try {
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';

    $query = "SELECT id_local, id_gerente, direccion, nombre_local, descripcion, num_mesas FROM locales";

    $result = $pdo->prepare($query);

    $result->execute();
} catch (PDOException $e) {
    $error = 'Unable to connect to the database server.';
}


$datos = [];

foreach ($result as $row) {
    $datos[0][] = array(
        'id_local'  => $row['id_local'],
        'nombre_local' =>   $row['nombre_local'],
        'descripcion' =>   obtenerDescripciones($row['id_local']),
        'url_Perfil' => imagePerfil($row['id_local'])
    );
}



echo json_encode($datos);


function obtenerDescripciones( $id_local ){
    $data = "";
    try {
        include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';

        $query = "SELECT descripcion FROM descripciones where id_local = :id";
        $result = $pdo->prepare($query);
        $result->bindValue(':id', $id_local);

        $result->execute();
    } catch (PDOException $e) {
        $error = 'Unable to connect to the database server.';
    }

    foreach ($result as $row){
            $data = $row['descripcion'];
        }

    return $data;
}
