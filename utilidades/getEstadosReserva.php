<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/header.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/helpers.inc.php';
    


$data = [
    'data'=>[], 
    'mensage'=>[]
];


    try {
    
        include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';
        $query = "SELECT id_estado, nombreEstado FROM `estadoreserva`";
        $result = $pdo->prepare($query);
       
        $result->execute();
       
        foreach($result as $row){
                $data['data'][] =['id_estado'=>$row['id_estado'], 'nombre'=>$row['nombreEstado']];
            }



        $data['mensage'] = ['mensageType' => 1,  'mensageText' => 'datos obtenidos'];
    
    
    } catch (PDOException $e) {
        $data['mensage'] = ['mensageType' => 3,  'mensageText' => 'No se pueden obtener los datos de si el usuario es hostelero.'];
        echo json_encode($data);
        exit();
    }

    echo json_encode($data);
    exit();



    