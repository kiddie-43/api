<?php
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/helpers.inc.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/informacionLocal.php';
$id_local = (isset($_GET['id_local'])) ? (html($_GET['id_local'])) : 0;

$data = [
    'datos'     => [],
    'mensage'   => []
];

// SELECT locales.id_local , locales.direccion, locales.nombre_local, locales.descripcion, comentarios.comentario, comentarios.puntuacion, avg(comentarios.puntuacion)*10 FROM locales, comentarios where locales.id_local = 2 and comentarios.id_local = 2;
try {
    
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';
    $query = "SELECT id_local, nombre_local FROM locales where id_local = :id";
    $result = $pdo->prepare($query);
    $result->bindValue(":id", $id_local);
    $result->execute();
    if($id_local > 0 ){
        $data['mensage'] = ['mensageType' => 1,  'mensageText' => 'datos obtenidos'];
    }


} catch (PDOException $e) {
    $data['mensage'] = ['mensageType' => 3,  'mensageText' => 'No se pueden obtener los datos del local.'];
    echo json_encode($data);
    exit();
}

foreach ($result as $row) {

    $data['datos'] = array(
        'id_local'  => $row['id_local'],
        'direccion' =>  concatenarDireccion( obtenerDireccion($row['id_local'])),
        'nombre_local' =>   $row['nombre_local'],
        'descripcion' =>  obtenerDescripciones($row['id_local']),
        'carrusel' => carruselImagenes($row['id_local']),
        'valoracion'=> getMediaLocal($row['id_local'])
    );
}

echo json_encode($data);

