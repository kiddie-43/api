<?php

    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/header.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/helpers.inc.php';
   
    $json = file_get_contents('php://input');
    $params = json_decode($json);

        
    // local donde se realzia la reserva 
    $id_local  = html($params->idLocal);

    // usuario que realiza la reserva 
    $id_usuario = html($params->idUsuario);
    
    // fecha de la reserva
    $fecha = html($params->fechaReserva);

    // hora de la reserva 
    $hora = html($params->horaReserva);

    // numero de personas de la mesa
    $num_Personas = html($params->numPersonas);

    // dentro o terraza si la tiene
    $zona = html($params->zonaLocal);



// si no hay aforo para ka reserva 
$response = ['data'=>'', 'error'=> 'No hay aforo para esta reserva'];
// si el local esta cerrado en ese momento 
$response = ['data'=>'', 'error'=> 'El local esta cerrado en este horario'];


// la reserva se ha realizado correctamente 

$response = [
    'data'=> [
    'id_reserva' => ' ', 
    'fecha'=> '', 
    'hora'=> '', 
    'num_Personas'=>''

]     
, 'error'=> ''
];

