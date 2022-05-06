<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/header.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/helpers.inc.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/informacionLocal.php';
    // $json = file_get_contents('php://input');
    // $params = json_decode($json);

$id_usuario = html($_GET['id_usuario']);
$id_local = html ($_GET['id_local']);

    $data = [
        'data'      => [  'usuario'=>[], 'local'=>[] ], 
        'mensage'   => []

    ];


// obtener datos usuario 

    try {
        include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';
    
        $query = "SELECT`nombre_usuario`,`primer_apellido_usuario`,`segundo_apellido_usuario`,`telefono_user`,`email_user` FROM `usuarios` WHERE id_usuario = :id;";
    
        $result = $pdo->prepare($query);
    
       // $id = $esUsuario ? $id_usuario : obtenerIdLocal($id_usuario);
    
        $result->bindValue(':id', $id_usuario);
        $result->execute();
    
        foreach ($result as $row) {
            $data['data']['usuario'] = [
                'nombre' => $row['nombre_usuario'], 'apellidos' => $row['primer_apellido_usuario'] . " ". $row['segundo_apellido_usuario'], 'telefono' => $row['telefono_user'], 'email_user' => $row['email_user']
            ];
        }
    
        $data['mensage'] = ['mensageType' => 1, 'mensageText' => 'Datos obtenidos correctmene'];
    } catch (PDOException $e) {
        $error = 'Unable to connect to the database server.';
        $data['mensage'] = ['mensageType'=>3, 'mensageText'=>'No se puede obtener los datos del usuario'];
        exit();
    }

// obtener datos del local / restaurant 


try {
   
    $query = "SELECT `nombre_local` FROM `locales` WHERE id_local = :id;";

    $result = $pdo->prepare($query);

    $id = $id_local;

    $result->bindValue(':id', $id);
    $result->execute();

    foreach ($result as $row) {
        $data['data']['local'] = [
            'nombre' => $row['nombre_local'], 'direccion'=>concatenarDireccion (  obtenerDireccion($id)), 'zonas'=> obtenerZonasLocal($id)
                ];
    }

    $data['mensage'] = ['mensageType' => 1, 'mensageText' => 'Datos obtenidos correctmene'];
} catch (PDOException $e) {
    $error = 'Unable to connect to the database server.';
    $data['mensage'] = ['mensageType'=>3, 'mensageText'=>'No se puede obtener los datos del usuario'];
    exit();
}


echo json_encode($data);

function concatenarDireccion ( $direccion ){


return $direccion['comunidad'] .", ". $direccion['ciudad'] .", ". $direccion['calle'] .", ". $direccion['numeroCalle'] ;
}
