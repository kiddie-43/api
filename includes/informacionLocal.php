<?php

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

function concatenarDireccion($lista)
{
    return $lista['comunidad'] . ', ' . $lista['ciudad'] . ', ' . $lista['calle'] . ', ' . $lista['numeroCalle'];
}


function getMediaLocal($id_local)
{


    $datos = 0;
    try {

        include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';

        $query = "SELECT  AVG(comentarios.puntuacion)*10 as media FROM `comentarios` WHERE id_local = :id;";
        $result = $pdo->prepare($query);
        $result->bindValue(':id', $id_local);

        $result->execute();
    } catch (PDOException $e) {
        $data['mensage']['mensajeType'] = 3;
        $data['mensage']['mensajeText'] = 'No ha sido posible obtener la valoracion';
        echo json_encode($data);
        exit();
    }

    foreach ($result as $row) {
        $datos = intVal($row['media']);
    }

    return $datos;
}

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

// Incruir utilidad del id del local para
function obtenerIdLocal($id_usuario)
{
    $id = 0;
    try {

        include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';
        $query = "SELECT `id_local` FROM `locales` WHERE id_gerente =id_gerente WHERE id_usuario= :id";
        $result = $pdo->prepare($query);
        $result->bindValue(":id", $id_usuario);
        $result->execute();
        foreach ($result as $row) {
            $id = $row['id'];
        }



        $data['mensage'] = ['mensageType' => 1,  'mensageText' => 'datos obtenidos'];
    } catch (PDOException $e) {
        $data['mensage'] = ['mensageType' => 3,  'mensageText' => 'No se pueden obtener los datos de si el usuario es hostelero.'];
        echo json_encode($data);
        exit();
    }


    return $id;
}
function obtenerZonasLocal($id)
{
    $data = [];
    try {

        include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';
        $query = "SELECT `id_zona`, `nombre`, descripcion FROM `zonalocal` WHERE `id_local` = :id";
        $result = $pdo->prepare($query);
        $result->bindValue(":id", $id);
        $result->execute();
        foreach ($result as $row) {
            $data[] = ['id_zona' => $row['id_zona'], 'nombre' => $row['nombre'], 'descripcion'=>$row['descripcion']];
        }



        //$data['mensage'] = ['mensageType' => 1,  'mensageText' => 'datos obtenidos'];
    } catch (PDOException $e) {
        $data['mensage'] = ['mensageType' => 3,  'mensageText' => 'No se pueden obtener los datos de si el usuario es hostelero.'];
        echo json_encode($data);
        exit();
    }

    return $data;
}
