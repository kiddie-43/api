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

try {

    // conexion base de datos
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';
    // Montar query
    $query = "INSERT INTO `users`(`nombre_usuario`, `nombre_publico`, `primerape_usuario`, `segundoape_usuario`, `telefono_user`, `email_user`, `pass`) VALUES ('$nombre_user', '$nick_user', '$primer_apellido_user', '$segundo_apellido_user', '$telefono_user' , '$user_email', '$pass_user' )";

   $query = "UPDATE `users` SET `nombre_usuario`=$name,`nombre_publico`=$nick_user,`telefono_user`=$telefono,`email_user`=$email WHERE email_user= $email "
    // Realizar peticion al server
    $result = $pdo->prepare($query); 
       
        
        $result->execute();
        
     
        $response = [
            'id'    =>  "", 
            'message' =>   'La operacion se ha completado correctamente'
        ];
        
        echo json_encode( $data );

    } catch (PDOException $e) { }
