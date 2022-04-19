<?php


include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/helpers.inc.php';

$json = file_get_contents('php://input');
$params = json_decode($json);

$nick_user = html ($params->nickUser);
$name = html ($params->nombreUser);
$telefono = html($params->telefonoUser);
$email = html($params->emailUser) ;
$id_user = intval( html($params->id));


try {

    // conexion base de datos
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';
    // Montar query
   $query = "UPDATE `users` SET `nombre_usuario`=$name,`nombre_publico`=$nick_user,`telefono_user`=$telefono,`email_user`=$email WHERE 'id_user'= $id_user";
    // // Realizar peticion al server
    $result = $pdo->prepare($query); 
    $result->execute();
        
 
        $response = [
            'id'    =>  "", 
            'message' =>   'La operacion se ha completado correctamente'
        ];
        
        echo json_encode( $response );

} catch (PDOException $e) { }
