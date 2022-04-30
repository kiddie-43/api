<?php
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/helpers.inc.php';

$id_local = (isset($_GET['id_local'])) ? (html($_GET['id_local'])) : 0;
$response = ['mensaje' => [], 'datos' => []];

$comentarios;
// SELECT locales.id_local , locales.direccion, locales.nombre_local, locales.descripcion, comentarios.comentario, comentarios.puntuacion, avg(comentarios.puntuacion)*10 FROM locales, comentarios where locales.id_local = 2 and comentarios.id_local = 2;



try {

    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';

    $query = "SELECT `id_usuario`, `comentario`, `puntuacion` FROM `comentarios` WHERE `id_local` = :id;";

    $dataComentarios = $pdo->prepare($query);
    $dataComentarios->bindValue(":id", $id_local);
    $dataComentarios->execute();
} catch (PDOException $e) {
    $error = 'No se pueden obtener los datos del local.';
    $response['error'] = ['tipoMensaje' => 3,  'mensaje' => $error];
}

foreach ($dataComentarios as $comentario) {
}




$datos;





try {


    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';

    $query = "SELECT id_local, direccion, nombre_local, descripcion FROM locales where id_local = :id";


    $result = $pdo->prepare($query);
    $result->bindValue(":id", $id_local);
    $result->execute();
} catch (PDOException $e) {

    $error = 'No se pueden obtener los datos del local.';
    $response['error'] = ['tipoMensaje' => 3,  'mensaje' => $error];
}

foreach ($result as $row) {

    $datos = array(
        'id_local'  => $row['id_local'],
        'direccion' =>   obtenerDireccion($row['id_local']),
        'nombre_local' =>   $row['nombre_local'],
        'descripcion' =>  obtenerDescripciones($row['id_local']),
        'carrusel' => carruselImagenes($row['id_local']),
      //  'comentarios' => obtenerComentarios($row['id_local'])
    );
}






echo json_encode($datos);


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
        $error = 'Unable to connect to the database server.';
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
        $error = 'Unable to connect to the database server.';
    }

    foreach ($result as $row) {
        $data = ['calle' => $row['nombre_calle'], 'numeroCalle' => $row['num_calle'], 'ciudad' => $row['ciudad'], 'comunidad' => $row['comunidad']];
    }

    return $data;
}


function obtenerComentarios($id_local)
{
    $data = ['comentarios' => [], 'valoracion' => 0];
    try {
        include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';

        $query = "SELECT comentarios.id_comentario as id, comentarios.comentario as comentario, comentarios.puntuacion as valoracion, usuarios.nombre_usuario as nombre_usuario, usuarios.id_usuario as id_usuario FROM locales , comentarios inner join usuarios on comentarios.id_usuario = usuarios.id_usuario WHERE locales.id_local = :id ORDER BY comentarios.fechaComentario DESC; ";
        $result = $pdo->prepare($query);
        $result->bindValue(':id', $id_local);

        $result->execute();
    } catch (PDOException $e) {
        $error = 'Unable to connect to the database server.';
    }

    foreach ($result as $row) {

        $data['comentarios'][] = array(
            'id' => $row['id'], 'comentario' => $row['comentario'], 'valoracion' => $row['valoracion'], 'nombre_usuario' => $row['nombre_usuario'], 'id_usuario' => $row['id_usuario'], 'perfil' => imagePerfil($row['id_usuario'], true)
        );
        // , 'perfil'=> imagePerfil($row['id_usuario'], true)
    }

    $data['valoracion'] = obtenerMedia($id_local);


    return $data;
}



function obtenerMedia($id_local){
    
    // SELECT AVG(comentarios.puntuacion)*10 as media FROM `comentarios` WHERE id_local = 2;
    $data = 0;

    try {
        include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';

        $query = "SELECT  AVG(comentarios.puntuacion)*10 as media FROM `comentarios` WHERE id_local = :id;";
        $result = $pdo->prepare($query);
        $result->bindValue(':id', $id_local);

        $result->execute();
    } catch (PDOException $e) {
        $error = 'Unable to connect to the database server.';
    }

    foreach ($result as $row) {

        $data = $row['media'];
        // , 'perfil'=> imagePerfil($row['id_usuario'], true)
    }

   

    return intVal($data);




   // return ($nota / $comentarios) * 10;
}
