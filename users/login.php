<?php
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/helpers.inc.php';
// obtener email 
// password 

$email = "asda@gmail.com";

// ver si esta definida las variables 
// $email = (isset($_GET['email'])) ? (html($_GET['email'])) : "";
// $pass = (isset($_GET['pass'])) ? (html($_GET['pass'])) : "";


$pas = "123";
try {

// conexion base de datos
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';
// Montar query
    $query = "SELECT COUNT(*) as estado,  id_user, email_user, pass FROM users where email_user = :email and pass = :pas";

    // Realizar peticion al server
    $result = $pdo->prepare($query);

    $result->bindValue(":email", $email);
    $result->bindValue(":pas", $pas);
    $result->execute();
   
} catch (PDOException $e) {
    echo json_encode('Unable to connect to the database server.');
}

// Añadir datos  
foreach ($result as $row) {
    
    $datos = array(
        'id_user'   => ($row['estado'] !== 0) ? $row['id_user'] : -1
    );

}



 echo json_encode($datos);