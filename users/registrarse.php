<?php


include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/helpers.inc.php';

$json = file_get_contents('php://input');

$params = json_decode($json);

// obtener datos de angular 
$nick_user                  = html ( $params->nickUser         ); 
$nombre_user                = html ( $params->nombreUser       ); 
$primer_apellido_user       = html ( $params->primer_apellido  );
$segundo_apellido_user      = html ( $params->segundo_apellido );
$telefono_user              = html ( $params->telefono         );
$user_email                 = html ( $params->emailUser       );
$pass_user                  = html ( $params->passUser         );
$confirmar_pass_user        = html ( $params->confirmarPassUser  );

// $nick_user                  =  $params->nickUser     ;     
// $nombre_user                =  $params->nombreUser  ;      
// $primer_apellido_user       =  $params->primer_apellido  ;
// $segundo_apellido_user      =  $params->segundo_apellido ;
// $telefono_user              =  $params->telefono         ;
// $user_email                 =  $params->emailUser       ;
// $pass_user                  =  $params->passUser         ;
// $confirmar_pass_user        =  $params->confirmarPassUser  ;
// $registrado ; 
// // devolvera al cliente si esta registrado o no ( devolvera el id,  un booleano y un error )
// $resultado  ;

// ver si la contraseñas son iguales 

    // Ver si esta registrado antes 

    // try {

    //     // conexion base de datos
    //         include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';
    //     // Montar query
    //         $query = "SELECT COUNT(*) as estado FROM users where email_user = :email ";
        
    //         // Realizar peticion al server
    //         $result = $pdo->prepare($query);
        
    //         $result->bindValue(":email", $user_email);
           
    //         $result->execute();
            
    //         foreach ($result as $row) {
    //             $registrado =  ($row['estado'] !== 0 ) ? true : false;
    //         }
                
    
    //     } catch (PDOException $e) {
    //         echo json_encode('Unable to connect to the database server.');
    //     }


if ( $registrado ){

    $resultado  = [ 'error' => "El usuario ya esta registrado" ];
    //echo json_encode($resultado);
}







    try {

    // conexion base de datos
        include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';
    // Montar query
// "    INSERT INTO `users`(`nombre_usuario`, `nombre_publico`, `primerape_usuario`, `segundoape_usuario`, `telefono_user`, `email_user`, `pass`) VALUES ('$nombre_user', '$nick_user', '$primer_apellido_user', '$segundo_apellido_user', '$telefono_user' , '$user_email', '$pass_user' )"
// $query = "INSERT INTO `users`(`nombre_usuario`, `nombre_publico`, `primerape_usuario`, `segundoape_usuario`, `telefono_user`, `email_user`, `pass`) VALUES ($nombre_user, $nick_user, $primer_apellido_user,$segundo_apellido_user, $telefono_user , $user_email, $pass_user )";    
$query = "    INSERT INTO `users`(`nombre_usuario`, `nombre_publico`, `primerape_usuario`, `segundoape_usuario`, `telefono_user`, `email_user`, `pass`) VALUES ('$nombre_user', '$nick_user', '$primer_apellido_user', '$segundo_apellido_user', '$telefono_user' , '$user_email', '$pass_user' )";

    
        // Realizar peticion al server
        $result = $pdo->prepare($query); 
       
        // :nombre,:nick,:primero,:segundo,:telefono,:email,:pass
       
       
        // $result->bindValue(":nombre", $nombre_user);
        
        // $result->bindValue(":nick", $nick_user);
        // $result->bindValue(":primero", $primer_apellido_user);
        // $result->bindValue(":segundo", $segundo_apellido_user);      

        // $result->bindValue(":telefono", $telefono_user);     
        // $result->bindValue(":email", $user_email);
        // $result->bindValue(":pass", $pass_user);
        
        $result->execute();
     
    } catch (PDOException $e) {
       
       // echo json_encode('Unable to connect to the database server.');    
    }






