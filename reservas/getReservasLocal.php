<?php

include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/helpers.inc.php';

$json = file_get_contents('php://input');
$params = json_decode($json);

$id_usuario =   obtenerIdLocal(html($params->id));

$data = [
    'data'      => [],
    'mensage'   => []
];

$where = " WHERE reserva.id_usuario = :id ";


try {
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';

    $query = "SELECT reserva.id_reserva, locales.id_local, locales.nombre_local, reserva.hora_reserva, reserva.fecha_reserva, usuarios.nombre_usuario, zonalocal.nombre as 'zonaReserva', zonalocal.descripcion as 'descripcionZona', reserva.num_personas as 'personas', estadoreserva.nombreEstado FROM reserva INNER JOIN locales on reserva.id_local = locales.id_local INNER JOIN usuarios on reserva.id_usuario = usuarios.id_usuario INNER JOIN zonalocal on zonalocal.id_zona = reserva.zona_reserva inner join estadoreserva on reserva.id_estado = estadoreserva.id_estado  WHERE locales.id_local = :id ORDER BY reserva.fecha_reserva DESC;";

    $result = $pdo->prepare($query);

    $id = $esUsuario ? $id_usuario : obtenerIdLocal($id_usuario);

    $result->bindValue(':id', $id_usuario);
    $result->execute();

    foreach ($result as $row) {
        $data['data'][] = [
            'id_reserva' => $row['id_reserva'], 'id_local' => $row['id_local'], 'nombre_local' => $row['nombre_local'], 'hora' => $row['hora_reserva'], 'fecha' => $row['fecha_reserva'], 'nombre_usuario' => $row['nombre_usuario'], 'zona_reserva' => $row['zonaReserva'], 'descripcion_zona' => $row['descripcionZona'], 'num_personas_mesa' => $row['personas'], 'nombreEstado' => $row['nombreEstado']
        ];
    }

    $data['mensage'] = ['mensageType' => 1, 'mensageText' => 'Datos obtenidos correctmene'];
} catch (PDOException $e) {
    $error = 'Unable to connect to the database server.';
}

echo json_encode($data);

// si el usuario no tiene reservas 
$response = ['data' => ' ', 'error' => 'No dispones de ninguna reserva'];



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
