<?php


include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/helpers.inc.php';

$json = file_get_contents('php://input');
$params = json_decode($json);

$nick_user                  = html($params->nickUser);
$nombre_user                = html($params->nombreUser);
$primer_apellido_user       = html($params->primer_apellido);
$segundo_apellido_user      = html($params->segundo_apellido);
$telefono_user              = html($params->telefono);
$user_email                 = html($params->emailUser);
$pass_user                  = html($params->passUser);
$confirmar_pass_user        = html($params->confirmarPassUser);



// $nick_user                  = "Hola mundo";
// $nombre_user                = "Hola mundo";
// $primer_apellido_user       = "Hola mundo";
// $segundo_apellido_user      = "Hola mundo";
// $telefono_user              = "987654123";
// $user_email                 = "mundo@gmail.com";
// $pass_user                  = "dfeb4a50482677fc4e97f0d677433b2f";
// $confirmar_pass_user        = "dfeb4a50482677fc4e97f0d677433b2f";

$data = [
    'data' => [],
    'mensage' => []
];

$temporal;
//$temp = comprobarNick($nick_user);
try {

    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';
    $query = "SELECT count(*) as registrado from usuarios where nombre_publico = :nick";
    $result = $pdo->prepare($query);
    $result->bindValue(':nick', $nick_user);
    $result->execute();

    foreach ($result as $row) {
        $temporal = ($row['registrado'] != 0) ? true : false;
    }
} catch (PDOException $e) {
    $data['mensage'] = ['mensageType' => 3, 'mensageText' => 'El nick introducido no esta disponible'];
    echo json_encode($data);
    exit();
}

if ($temporal) {
    $data['mensage'] = ['mensageType' => 3, 'mensageText' => 'El nick introducido no esta disponible'];
    echo json_encode($data);
    exit();
}

//$temp = comprobarEmail($user_email);

try {

    // conexion base de datos

    // Montar query
    $query = "SELECT count(*) as registrado from  usuarios where email_user = :email";

    $result = $pdo->prepare($query);
    $result->bindValue(':email', $user_email);
    $result->execute();

    foreach ($result as $row) {
        $temporal = ($row['registrado'] != 0) ? true : false;
    }
} catch (PDOException $e) {
    $data['mensage'] = ['mensageType' => 3, 'mensageText' => 'El email introducido no esta disponible'];
    echo json_encode($data);
    exit();
}

if ($temporal) {
    $data['mensage'] = ['mensageType' => 3, 'mensageText' => 'El email introducido no esta disponible'];
    echo json_encode($data);
    exit();
}

try {
    // conexion base de datos
    // Montar query
    $query = "SELECT count(*) as registrado from  usuarios where telefono_user = :telefono";


    $result = $pdo->prepare($query);
    $result->bindValue(':telefono', $telefono_user );
    $result->execute();

    foreach ($result as $row) {
        $temporal = ($row['registrado'] != 0) ? true : false;
    }
} catch (PDOException $e) { 
    $data['mensage'] = ['mensageType' => 3, 'mensageText' => 'El telefono introducido no esta disponible'];
    echo json_encode($data);
    exit();
}

if ($temporal) {
    $data['mensage'] = ['mensageType' => 3, 'mensageText' => 'El telefono introducido no esta disponible'];
    echo json_encode($data);
    exit();
}

    try {

        // conexion base de datos
        // Montar query
        $query = "INSERT INTO `usuarios`(`nombre_usuario`, `nombre_publico`, `primer_apellido_usuario`,`segundo_apellido_usuario`, `telefono_user`, `email_user`, `pass`) VALUES ('$nombre_user', '$nick_user', '$primer_apellido_user', '$segundo_apellido_user', '$telefono_user' , '$user_email', '$pass_user' )";
    
    
        // Realizar peticion al server
        $result = $pdo->prepare($query);
    
    
        $result->execute();
        $id = $pdo->lastInsertId();
        $data['mensage'] = ['mensageType' => 1, 'mensageText' => 'usuario registrado'];
        $data['data'] =   $id ;
           
      $rutaUsuario = $_SERVER['DOCUMENT_ROOT'] . "/api/img/usuarios/$id";  

   
   
   if (!is_dir( $rutaUsuario)){
    
    if (mkdir($rutaUsuario, 0777, true)){
    echo json_encode($data);       
    }
    
    
   }
    
    
   
    } catch (PDOException $e) {
        $data['mensage'] = ['mensageType' => 3, 'mensageText' => 'no se pudo crear el usuario'];
        echo json_encode($data);
        exit();
    }     
    
