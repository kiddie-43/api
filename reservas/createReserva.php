<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/header.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/helpers.inc.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/informacionLocal.php';
    // $json = file_get_contents('php://input');
    // $params = json_decode($json);

    // $id_local = html($params->id_local);
    // $id_usuario = html($params->id_usuario);
    // $num_personas = html($params->numPersonas);
    // $fecha = html($params->fecha);
    // $hora = html($params->hora);
    // $zona_id = html($params->zonaLocal);
    // $comentario = html($params->comentario);


    $id_local = html(2);
    $id_usuario = html(1);
    $num_personas = html(4);
    $fecha = html('2022-05-05');
    $hora = html('19:30');
    $zona_id = html(1);
    $comentario = html('prueba de insertar reserva pasasda');
$num_mesas = $num_mesas_ocupadas = 0;

    // obtener las mesas del lugar que desea el usuario 

    try {
        include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';
    
        $query = "SELECT  `num_mesas` FROM `mesas` WHERE id_zona = :id_zona and id_local=:id_local";
    
        $result = $pdo->prepare($query);
    
       // $id = $esUsuario ? $id_usuario : obtenerIdLocal($id_usuario);
    
        $result->bindValue(':id_zona', $zona_id);
        
        $result->bindValue(':id_local', $id_local);
        $result->execute();
    
        foreach ($result as $row) {
           $num_mesas = $row['num_mesas'];
        }
    
        
    } catch (PDOException $e) {
        $error = 'Unable to connect to the database server.';
       
       echo $error;
        $data['mensage'] = ['mensageType'=>3, 'mensageText'=>'No se puede obtener los datos del usuario'];
        exit();
    }






// obtener mesas ocupadas ese dia 

//SELECT sum(num_personas) from reserva WHERE fecha_reserva = '2022-05-05' AND id_estado != 4; 
    
try {
   // include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';

    $query = "SELECT sum(num_personas) as mesas_ocupadas from reserva WHERE fecha_reserva = :fecha AND id_estado != 4;";

    $result = $pdo->prepare($query);
    $result->bindValue(':fecha', $fecha);
    
    //$result->bindValue(':id_local', $id_local);
    $result->execute();

    foreach ($result as $row) {
       $num_mesas_ocupadas = $row['mesas_ocupadas'] == null ? 0 : $row['mesas_ocupadas'] ;
    }

    
} catch (PDOException $e) {
    $error = 'Unable to connect to the database server.';
    $data['mensage'] = ['mensageType'=>3, 'mensageText'=>'No se puede obtener los datos del usuario'];
    exit();
}


if ($num_mesas - $num_mesas_ocupadas > 0 ){
    $id_estado = 2;
} else {
    $id_estado = 1;
}



try {
    // include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';
 
    $query = "INSERT INTO `reserva`( `id_local`, `id_usuario`, `fecha_reserva`, `hora_reserva`, `num_personas`, `zona_reserva`, `descripcion`, `id_estado`) VALUES (:id_local, :id_usuario,:fecha,:hora,:num_personas,:id_zona,:comentario,:id_estado)";
 
    $result = $pdo->prepare($query);
    $result->bindValue(':id_local', $id_local);
    $result->bindValue(':id_usuario', $id_usuario);
    
    $result->bindValue(':fecha', $fecha);
    $result->bindValue(':hora', $hora);
    $result->bindValue(':id_zona', $zona_id);
    $result->bindValue(':comentario', $comentario);
    $result->bindValue(':id_estado', $id_estado);

    $result->bindValue(':num_personas', $num_personas);



    $result->execute();
  echo json_encode($result);
 } catch (PDOException $e) {
     $error = 'Unable to connect to the database server.';
     $data['mensage'] = ['mensageType'=>3, 'mensageText'=>'No se puede obtener los datos del usuario'];
    
    echo $e;
     exit();
 }



//INSERT INTO `reserva`( `id_local`, `id_usuario`, `fecha_reserva`, `hora_reserva`, `num_personas`, `zona_reserva`, `descripcion`, `id_estado`) VALUES ('[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]')









//echo $mensage;

