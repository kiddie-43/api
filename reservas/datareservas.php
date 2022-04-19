<?php

    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/header.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/helpers.inc.php';
   
    // $json = file_get_contents('php://input');
    // $params = json_decode($json);

    $id_usuario = html($_GET['id_usuario']);




    
// si el usuario no tiene reservas 
$response = ['data'=> ' ', 'error'=> 'No dispones de ninguna reserva']; 



