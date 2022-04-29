<?php
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/header.php';


include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs.php';


include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/helpers.inc.php';

$id_local = (isset($_GET['id_local'])) ? (html($_GET['id_local'])) : 0;
$response = [ 'mensaje' => [], 'datos' => [] ];

$comentarios ; 
// SELECT locales.id_local , locales.direccion, locales.nombre_local, locales.descripcion, comentarios.comentario, comentarios.puntuacion, avg(comentarios.puntuacion)*10 FROM locales, comentarios where locales.id_local = 2 and comentarios.id_local = 2;



try {

    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';

    $query = "SELECT `id_usuario`, `comentario`, `puntuacion` FROM `comentarios` WHERE `id_local` = :id;";
    
    $dataComentarios = $pdo->prepare($query);
    $dataComentarios->bindValue(":id", $id_local);
    $dataComentarios->execute();
} catch (PDOException $e) {
    $error = 'No se pueden obtener los datos del local.';
    $response ['error'] = [ 'tipoMensaje'=> 3,  'mensaje'=>$error ];
}

foreach ($dataComentarios as $comentario){



}




$datos ; 





try {


    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';

    $query = "SELECT id_local, direccion, nombre_local, descripcion FROM locales where id_local = :id";

    
    $result = $pdo->prepare($query);
    $result->bindValue(":id", $id_local);
    $result->execute();
} catch (PDOException $e) {
    
    $error = 'No se pueden obtener los datos del local.';
    $response ['error'] = [ 'tipoMensaje'=> 3,  'mensaje'=>$error ];

}

foreach ($result as $row) {

    $datos = array(
        'id_local'  => $row['id_local'],
        'direccion' =>   $row['direccion'],
        'nombre_local' =>   $row['nombre_local'],
        'descripcion' =>  obtenerDescripciones( $row['id_local']),
        'carrusel' => carruselImagenes( $row['id_local'] )
    );
}






echo json_encode($datos);


function obtenerDescripciones( $id_local ){
    $data = [];
    try {
        include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';

        $query = "SELECT descripcion, carta FROM descripciones where id_local = :id";
        $result = $pdo->prepare($query);
        $result->bindValue(':id', $id_local);

        $result->execute();
    } catch (PDOException $e) {
        $error = 'Unable to connect to the database server.';
    }

    foreach ($result as $row){
            $data =[ 'descripcion'=>$row['descripcion'] , 'carta' => $row['carta']  ] ;
        }

    return $data;
}


function obtenerDireccion() {

/* SELECT ciudades.nombre_ciudad, comunidadautonoma.nombre_comunidad FROM comunidadautonoma, ciudades WHERE comunidadautonoma.id_comunidad = ciudades.id_ciudad and ciudades.id_ciudad = (
SELECT id_ciudad FROM locales WHERE locales.id_local = 2
) 
/*

}




