<?php
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/helpers.inc.php';

// ver si esta definida las variables 

$json = file_get_contents('php://input');
$params = json_decode($json);

/*
 $user_email = (isset($_GET['email'])) ? (html($_GET['email'])) : "";
 $user_pass = (isset($_GET['pass'])) ? (html($_GET['pass'])) : "";
*/

$user_email = html($params->email);
$user_pass = html($params->pass);



$data = [
    'data'=> ['id_usuario' => -1 ], 
    'mensage' => [ ]
]; 




try {

    // conexion base de datos
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';
    // Montar query
    $query = "SELECT COUNT(*) as registrado,  id_usuario, email_user, pass FROM usuarios where email_user = '$user_email' ";
    $result = $pdo->prepare($query);
  //  $result->bindValue(":email", $user_email);

    $result->execute();
   
} catch (PDOException $e) {
    $data['mensage']= ['mensageType' =>3, 'mensageText'=> 'Usuario no registrado'];
}


$id_usuario = 0 ;
$pass_validacion = '';
// cargar datos para las comprovaciones   
foreach ($result as $row) {

    

$pass_validacion = $row['pass'];
$id_usuario =  $row['id_usuario'] ;



}


if ($id_usuario == 0){
    $data['mensage']= ['mensageType' =>3, 'mensageText'=> 'Usuario no registrado'];
}else if ($pass_validacion != $user_pass) {
    $data['mensage']= ['mensageType' =>3, 'mensageText'=> 'Contraseña incorrecta'];
} else {
    $data['mensage']= ['mensageType' =>1, 'mensageText'=> 'Datos correctos'];
    $data['data']['id_usuario'] = $id_usuario;
}





 echo json_encode($data);
exit();
