<?php
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/helpers.inc.php';

$id_user = (isset($_GET['id'])) ? (html($_GET['id'])) : "";
//$id_user = 0;
$ejemplo = count(explode(" ", $id_user));

$response = [ 'data'=>[] , 'error'=>"",
];


if ($ejemplo <= 0 ){

    $response['error'] = "Es necesario iniciar sesion";
    
    echo json_encode($response);

}

try {

    // conexion base de datos
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';
    // Montar query
    $query = "SELECT `nombre_usuario`,`nombre_publico`, `telefono_user`,`email_user` FROM `users` WHERE id_user = $id_user ";

   
    $result = $pdo->prepare($query); 
       
        
    $result->execute();
 foreach ($result as $row ) {
    $response ['data'] = [
        "nick" => $row['nombre_publico'], 
        "nombre"=>$row['nombre_usuario'] , 
        "telefono"=> $row['telefono_user'], 
        "email" => $row['email_user'], 
    ]; 


 }

     
        
    echo json_encode( $response );

    } catch (PDOException $e) { }


