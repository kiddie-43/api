<?php

include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/helpers.inc.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/informacionLocal.php';
// $json = file_get_contents('php://input');
// $params = json_decode($json);

// $id_usuario = html($params->id);
// $esUsuario = $params->usuario;
$id_usuario = html($_GET['id_usuario']);

$data = [
    'data'      => [],
    'mensage'   => []
];

try {
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';

    //$query = "SELECT reserva.id_reserva, locales.id_local, locales.nombre_local, reserva.hora_reserva, reserva.fecha_reserva, usuarios.nombre_usuario, zonalocal.nombre as 'zonaReserva', zonalocal.descripcion as 'descripcionZona', reserva.num_personas as 'personas', estadoreserva.nombreEstado, reserva.id_estado	 FROM reserva INNER JOIN locales on reserva.id_local = locales.id_local INNER JOIN usuarios on reserva.id_usuario = usuarios.id_usuario INNER JOIN zonalocal on zonalocal.id_zona = reserva.zona_reserva inner join estadoreserva on reserva.id_estado = estadoreserva.id_estado WHERE reserva.id_usuario = :id  ORDER by id_reserva DESC";
    
    $query = "SELECT reserva.id_reserva, locales.id_local, locales.nombre_local, reserva.hora_reserva, reserva.fecha_reserva, usuarios.nombre_usuario,usuarios.primer_apellido_usuario, usuarios.segundo_apellido_usuario, usuarios.telefono_user, usuarios.email_user, zonalocal.nombre as 'zonaReserva', zonalocal.descripcion as 'descripcionZona', reserva.num_personas as 'personas', estadoreserva.nombreEstado, reserva.id_estado, zonalocal.id_zona, reserva.descripcion FROM reserva INNER JOIN locales on reserva.id_local = locales.id_local INNER JOIN usuarios on reserva.id_usuario = usuarios.id_usuario INNER JOIN zonalocal on zonalocal.id_zona = reserva.zona_reserva inner join estadoreserva on reserva.id_estado = estadoreserva.id_estado WHERE reserva.id_usuario = :id ORDER by id_reserva DESC;";
    
    $result = $pdo->prepare($query);


    $result->bindValue(':id', $id_usuario);
    $result->execute();

    
    foreach ($result as $row) {
        $data['data'][] = [
            'id_reserva' => $row['id_reserva'], 'id_local' => $row['id_local'], 'nombre_local' => $row['nombre_local'], 'hora' => $row['hora_reserva'], 'fecha' => $row['fecha_reserva'], 'nombre_usuario' => $row['nombre_usuario'], 'zona_reserva' => $row['zonaReserva'], 'descripcion_zona' => $row['descripcionZona'], 'num_personas_mesa' => $row['personas'], 'nombreEstado' => $row['nombreEstado'],'idEstado'=>$row['id_estado'], 
            'urlPerfil'=> imagePerfil($row['id_local'], false), 'primer_apellido_usuario'=>$row['primer_apellido_usuario'], 'segundo_apellido_usuario'=>$row['segundo_apellido_usuario'], 'telefono_user'=>$row['telefono_user'], 'email_user'=>$row['email_user'], 'direcion'=> concatenarDireccion(obtenerDireccion($row['id_local'])), 'id_zona'=>$row['id_zona'], 'comentario'=>$row['descripcion']
        ];
    }


    if (count($data['data']) == 0) {
        $data['mensage'] = ['mensageType' => 2, 'mensageText' => 'No hay reservas disponibles'];
    } else {
        $data['mensage'] = ['mensageType' => 1, 'mensageText' => 'Datos obtenidos correctmene'];
    }
} catch (PDOException $e) {
    $error = 'Unable to connect to the database server.';
}

echo json_encode($data);
exit();
