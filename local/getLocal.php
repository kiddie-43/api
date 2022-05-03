<?php
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/helpers.inc.php';

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
        'direccion' =>   obtenerDireccion($row['id_local']),
        'nombre_local' =>   $row['nombre_local'],
        'descripcion' =>  obtenerDescripciones($row['id_local']),
        'carrusel' => carruselImagenes($row['id_local']),
        'valoracion'=> getMediaLocal($row['id_local'])
    );
}

echo json_encode($data);

// Funciones unicas de un local
function obtenerDescripciones($id_local)
{
    $data = [];
    try {
        include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';

        $query = "SELECT descripcion, carta FROM descripciones where id_local = :id";
        $result = $pdo->prepare($query);
        $result->bindValue(':id', $id_local);

        $result->execute();
    } catch (PDOException $e) {
        $data['mensage'] = ['mensageType' => 3,  'mensageText' => 'No se pueden obtener las descripciones del local.'];
        echo json_encode($data);
        exit();
    }

    foreach ($result as $row) {
        $data = ['descripcion' => $row['descripcion'], 'carta' => $row['carta']];
    }

    return $data;
}

function obtenerDireccion($id_local)
{

    /* SELECT ciudades.nombre_ciudad, comunidadautonoma.nombre_comunidad FROM comunidadautonoma, ciudades WHERE comunidadautonoma.id_comunidad = ciudades.id_ciudad and ciudades.id_ciudad = (
SELECT id_ciudad FROM locales WHERE locales.id_local = 2
) 
*/
    //SELECT calles.nombre_calle, direcciones.num_calle, ciudades.nombre_ciudad, comunidadautonoma.nombre_comunidad  FROM calles INNER JOIN direcciones ON direcciones.id_ciudad = calles.id_ciudad INNER join ciudades on calles.id_ciudad = ciudades.id_ciudad INNER JOIN comunidadautonoma on ciudades.id_comunidad = comunidadautonoma.id_comunidad;  
    $data = [];
    try {
        include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';

        $query = "SELECT calles.nombre_calle as nombre_calle, direcciones.num_calle as num_calle, ciudades.nombre_ciudad as ciudad, comunidadautonoma.nombre_comunidad as comunidad FROM locales, calles INNER JOIN direcciones ON direcciones.id_ciudad = calles.id_ciudad INNER join ciudades on calles.id_ciudad = ciudades.id_ciudad INNER JOIN comunidadautonoma on ciudades.id_comunidad = comunidadautonoma.id_comunidad WHERE direcciones.id_local = :id;";
        $result = $pdo->prepare($query);
        $result->bindValue(':id', $id_local);

        $result->execute();
    } catch (PDOException $e) {
        $data['mensage'] = ['mensageType' => 3,  'mensageText' => 'No se pueden obtener la direccion del local.'];
        echo json_encode($data);
        exit();
    }

    foreach ($result as $row) {
        $data = ['calle' => $row['nombre_calle'], 'numeroCalle' => $row['num_calle'], 'ciudad' => $row['ciudad'], 'comunidad' => $row['comunidad']];
    }

    return $data;
}


function getMediaLocal ($id_local){


    $datos = 0;
    try {

        include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';
    
        $query = "SELECT  AVG(comentarios.puntuacion)*10 as media FROM `comentarios` WHERE id_local = :id;";
        $result = $pdo->prepare($query);
        $result->bindValue(':id', $id_local);
    
            $result->execute();
    } catch (PDOException $e) {
        $data ['mensage']['mensajeType'] = 3;
        $data ['mensage']['mensajeText'] = 'No ha sido posible obtener la valoracion';
        echo json_encode($data);
        exit();
    }
    
    foreach ($result as $row) {
        $datos = intVal($row['media']);        
    }
    
    return $datos;
}