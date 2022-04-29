<?php
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/helpers.inc.php';

$id_local = (isset($_GET['id_local'])) ? (html($_GET['id_local'])) : 0;


$datos ; 




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
        'direccion' =>   obtenerDireccion($row['id_local']),
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


function obtenerDireccion( $id_local ) {
     $data = [];
    try {
        include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';

        $query = "SELECT ciudades.nombre_ciudad, comunidadautonoma.nombre_comunidad, locales.id_gerente FROM comunidadautonoma inner JOIN ciudades on comunidadautonoma.id_comunidad = ciudades.id_ciudad INNER JOIN locales on ciudades.id_ciudad = locales.id_ciudad WHERE locales.id_local = :id;";
        $result = $pdo->prepare($query);
        $result->bindValue(':id', $id_local);

        $result->execute();
    } catch (PDOException $e) {
        $error = 'Unable to connect to the database server.';
    }

    foreach ($result as $row){
            $data =[ 'localidad'=>$row['nombre_ciudad'] , 'comunidadAutonoma' => $row['nombre_comunidad']  ] ;
        }

    return $data;
/* 
SELECT ciudades.nombre_ciudad, comunidadautonoma.nombre_comunidad FROM comunidadautonoma, ciudades WHERE comunidadautonoma.id_comunidad = ciudades.id_ciudad and ciudades.id_ciudad = (SELECT id_ciudad FROM locales WHERE locales.id_local = 2 ) ;

SELECT ciudades.nombre_ciudad, comunidadautonoma.nombre_comunidad, locales.id_gerente FROM comunidadautonoma inner JOIN ciudades on comunidadautonoma.id_comunidad = ciudades.id_ciudad INNER JOIN locales on ciudades.id_ciudad = locales.id_ciudad WHERE locales.id_local = 2;

*/

}