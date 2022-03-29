<?php
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/helpers.inc.php';

// ver si esta definida las variables 
$user_email = (isset($_GET['email'])) ? (html($_GET['email'])) : "";

$user_pass = (isset($_GET['pass'])) ? (html($_GET['pass'])) : "";


//$pas = "123";
try {

// conexion base de datos
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';
// Montar query
    $query = "SELECT COUNT(*) as estado,  id_user, email_user, pass FROM users where email_user = :email ";

    // Realizar peticion al server
    $result = $pdo->prepare($query);

    $result->bindValue(":email", $user_email);
   
    $result->execute();
   
} catch (PDOException $e) {
    echo json_encode('Unable to connect to the database server.');
}

// Añadir datos  
foreach ($result as $row) {
    
    $datos = array(
        'id_user'   => ( $row['estado'] !== 0 ) ? $row['id_user'] : -1,
        'error'     => ( $row['estado'] !== 0 ) ? validacionPassword($user_pass , $row['pass']  ) : "Usuario no registrado"
    );

}



 echo json_encode($datos);


// Valida si la  contraseña es correcta y si no hay errores  
function validacionPassword( $pass, $dataPass  ) {

return ($pass != $dataPass  ) ? "La contraseña no es correcta" : "";
 }