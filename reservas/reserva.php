<?php

    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/header.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/helpers.inc.php';
   
    $json = file_get_contents('php://input');
    $params = json_decode($json);

        
    // local donde se realzia la reserva 
    $id_local  = html($params->idLocal);

    // usuario que realiza la reserva 
    $id_usuario = html($params->idUsuario);
    
    // fecha de la reserva
    $fecha = html($params->fechaReserva);

    // hora de la reserva 
    $hora = html($params->horaReserva);

    // numero de personas de la mesa
    $num_Personas = html($params->numPersonas);

    // dentro o terraza si la tiene
    $zona = html($params->zonaLocal);





/*
// Sumaremos las mesas ocupadas por las reservas activas de la zona deseada 
-> se desea realizar una reserva para 3 personas 
-> en el local hay reservadas 17 / 20 personas
-> como el num de personas es = al aforo de la zona se realiza la reserva 



// obtendremos las mesas totales de la zona a la que se quiere reservar 

// si quedan zonas libres y la suma de la messa a reservar es igual o menor al aforo del local se reserva 


*/







// si no hay aforo para ka reserva 
$response = ['data'=>'', 'error'=> 'No hay aforo para esta reserva'];
// si el local esta cerrado en ese momento 
$response = ['data'=>'', 'error'=> 'El local esta cerrado en este horario'];


// la reserva se ha realizado correctamente 






//INSERT INTO `reserva` (`id_reserva`, `id_local`, `id_usuario`, `fecha_reserva`, `hora_reserva`, `num_personas`, `zona_reserva`, `descripcion`, `id_estado`) VALUES (NULL, '2', '3', CURRENT_DATE(), '19:00', '4', '1', 'Comida con amigos del real de madrid', '2');

/* 
Intento solo 1 consulta 

SELECT reserva.id_reserva, locales.id_local, locales.nombre_local, reserva.hora_reserva, reserva.fecha_reserva, reserva.id_usuario, usuarios.nombre_usuario, zonalocal.nombre, zonalocal.descripcion, reserva.num_personas as "personas ", estadoreserva.nombreEstado FROM reserva INNER JOIN locales on reserva.id_local = locales.id_local INNER JOIN usuarios on reserva.id_usuario = usuarios.id_usuario INNER JOIN zonalocal on zonalocal.id_zona = reserva.zona_reserva inner join estadoreserva on reserva.id_estado = estadoreserva.id_estado WHERE reserva.id_usuario = 3;

*/




$response = [
    'data'=> [
    'id_reserva' => ' ', 
    'fecha'=> '', 
    'hora'=> '', 
    'num_Personas'=>''

]     
, 'error'=> ''
];

function obtenerNumeroMesasZona ( $id_local, $id_zona) {
    try {
    
        include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';
        $query = "SELECT id_local, direccion, nombre_local, descripcion FROM locales where id_local = :id";
        $result = $pdo->prepare($query);
        $result->bindValue(":id", $id_local);
        $result->execute();
        if($id_local > 0 ){
            $data['mensage'] = ['mensageType' => 1,  'mensageText' => 'datos obtenidos'];
        }
    
    
    } catch (PDOException $e) {
        $data['mensage'] = ['mensageType' => 3,  'mensageText' => 'No se pueden obtener las mesas de la zona.'];
        echo json_encode($data);
        exit();
    }





}


function obtenerMesasOcupadasZona(){

}