<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/header.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/helpers.inc.php';
    
    $id_usuario = html($_GET['id_usuario']);

$data = [
    'data'=>[], 
    'mensage'=>[]
];

    if ($id_usuario == ''){
        $data['mensage'] = ['mensageType' => 3,  'mensageText' => 'No se pueden obtener los datos de si el usuario es hostelero.'];
        exit();
    }
    
    
    
    try {
    
        include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';
        $query = "SELECT COUNT(*) as hostelero, locales.id_local FROM usuarios INNER join locales on usuarios.id_usuario = locales.id_gerente WHERE id_usuario= :id";
        $result = $pdo->prepare($query);
        $result->bindValue(":id", $id_usuario);
        $result->execute();
            foreach($result as $row){
                $data['data'][] =['hostelero'=> $row['hostelero'] == 0 ? false : true , 'id_local'=>$row['hostelero'] == null ?  0: $row['id_local']  ];
            }



        $data['mensage'] = ['mensageType' => 1,  'mensageText' => 'datos obtenidos'];
    
    
    } catch (PDOException $e) {
        $data['mensage'] = ['mensageType' => 3,  'mensageText' => 'No se pueden obtener los datos de si el usuario es hostelero.'];
        echo json_encode($data);
        exit();
    }

    echo json_encode($data);
    exit();



    