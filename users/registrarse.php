<?php


include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/helpers.inc.php';

$json = file_get_contents('php://input');
$params = json_decode($json);



// ver si la contraseñas son iguales 

if (isset($_GET["comprobar_nick"])){
    
    combrobarNick ( html($_GET["comprobar_nick"]) );

} else if (isset($_GET["comprobar_email"])){
    combrobarEmail(html($_GET["comprobar_email"])));
} else if (isset($_GET["comprobar_telefono"])){
    combrobartelefono( html( $_GET["comprobar_telefono"] ) );
} else {
    registrar($params);
}













/*
   
    nick registrado 
    correo registrado 
    numero de telefono registrado 





*/


function combrobartelefono ( $telefono ){
    
    $respuesta;
    $temporal; 
    
    try {
        // conexion base de datos
        include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';
        // Montar query
        $query = "SELECT count(*) as registrado from users where telefono_user = :telefono";
    
       
        $result = $pdo->prepare($query); 
        $result->bindValue(':telefono', $telefono);      
        $result->execute();
       
        foreach($result as $row) {
            $temporal = ($row['registrado'] != 0 ) ? true : false ;       
        }
   
        
    
    } catch (PDOException $e) { }

if ($temporal ){

$respuesta = [
    'id' => -1, 
    'error' => 'El telefono introducido no esta disponible'
];

echo json_encode($respuesta);
}
}

function combrobarEmail ( $email ){
    
    $respuesta;
    $temporal; 
    
    try {

        // conexion base de datos
        include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';
       
        // Montar query
        $query = "SELECT count(*) as registrado from users where email_user = :email";
       
        $result = $pdo->prepare($query); 
        $result->bindValue(':email', $email);      
        $result->execute();
       
        foreach($result as $row) {
            $temporal = ($row['registrado'] != 0 ) ? true : false ;       
        }
         
            
            
            
    
    } catch (PDOException $e) { }

if ($temporal ){

$respuesta = [
    'id' => -1, 
    'error' => 'El correo introducido no esta disponible'
];

echo json_encode($respuesta);
}


}









function combrobarNick ( $nick ){
    
    $respuesta;
    $temporal; 
    
    try {

        // conexion base de datos
        include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';
        // Montar query
        $query = "SELECT count(*) as registrado from users where nombre_publico = :nick";
    
       
        $result = $pdo->prepare($query); 
        $result->bindValue(':nick', $nick);      
        $result->execute();
       
        foreach($result as $row) {
            $temporal = ($row['registrado'] != 0 ) ? true : false ;       
        }
         
            
            
            
    
    } catch (PDOException $e) { }

if ($temporal ){

$respuesta = [
    'id' => -1, 
    'error' => 'El nick introducido no esta disponible'
];

echo json_encode($respuesta);
}


}


function registrar($params){
  
    

    // obtener datos de angular 
    $nick_user                  = html ( $params->nickUser         ); 
    $nombre_user                = html ( $params->nombreUser       ); 
    $primer_apellido_user       = html ( $params->primer_apellido  );
    $segundo_apellido_user      = html ( $params->segundo_apellido );
    $telefono_user              = html ( $params->telefono         );
    $user_email                 = html ( $params->emailUser       );
    $pass_user                  = html ( $params->passUser         );
    $confirmar_pass_user        = html ( $params->confirmarPassUser  );
    
    try {

        // conexion base de datos
        include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';
        // Montar query
        $query = "INSERT INTO `users`(`nombre_usuario`, `nombre_publico`, `primerape_usuario`, `segundoape_usuario`, `telefono_user`, `email_user`, `pass`) VALUES ('$nombre_user', '$nick_user', '$primer_apellido_user', '$segundo_apellido_user', '$telefono_user' , '$user_email', '$pass_user' )";
    
       
        // Realizar peticion al server
        $result = $pdo->prepare($query); 
           
            
            $result->execute();
            $id = $pdo->lastInsertId();
         
            $data = [
                'id'    =>  $id, 
                'error' =>   ''
            ];
            
            echo json_encode( $data );
    
        } catch (PDOException $e) {
               
    }
    
}




