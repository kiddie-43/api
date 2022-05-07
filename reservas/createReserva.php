<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/header.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/helpers.inc.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/informacionLocal.php';
    $json = file_get_contents('php://input');
    $params = json_decode($json);

    $id_local = html($params->id_local);
    $id_usuario = html($params->id_usuario);
    $num_personas = html($params->numPersonas);
    $fecha = html($params->fecha);
    $hora = html($params->hora);
    $zona_id = html($params->zonaLocal);
    $comentario = html($params->comentario);

    // id_local: this.data.data.idLocal,
    // id_usuario: localStorage.getItem(environment.userCode),
    // numPersonas: this.createReservaForm.controls.numPersonas.value,
    // fecha: this.createReservaForm.controls.fecha.value,
    // hora: this.createReservaForm.controls.hora.value,
    // zonaLocal: this.createReservaForm.controls.zonaLocal.value,
    // comentario: this.createReservaForm.controls.comentario.value,




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
        $data['mensage'] = ['mensageType'=>3, 'mensageText'=>'No se puede obtener los datos del usuario'];
        exit();
    }






// obtener mesas ocupadas ese dia 

//SELECT sum(num_personas) from reserva WHERE fecha_reserva = '2022-05-05' AND id_estado != 4; 
    
try {
   // include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';

    $query = "SELECT sum(num_personas) from reserva WHERE fecha_reserva = :fecha AND id_estado != 4;";

    $result = $pdo->prepare($query);

   

    $result->bindValue(':fecha', $fecha);
    
    //$result->bindValue(':id_local', $id_local);
    $result->execute();

    foreach ($result as $row) {
       $num_mesas = $row['num_mesas'];
    }

    
} catch (PDOException $e) {
    $error = 'Unable to connect to the database server.';
    $data['mensage'] = ['mensageType'=>3, 'mensageText'=>'No se puede obtener los datos del usuario'];
    exit();
}




