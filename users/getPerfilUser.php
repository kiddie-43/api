<?php 


    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/header.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/helpers.inc.php';

    $id_usuario = html($_GET['id_usuario']);

    $data = [
        'data'      => [], 
        'mensage'   => []
    ];


    try {

        include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';
        $query = "SELECT `id_usuario`,`nombre_usuario`,nombre_publico, `email_user`,`telefono_user` FROM `usuarios` WHERE id_usuario = :id";
        $result = $pdo->prepare($query);
        $result->bindValue(':id', $id_usuario);
        $result->execute();
        foreach($result as $row){
            $data['data'] = ['id_usuario' => $row['id_usuario'],'nick'=>$row['nombre_publico'],'nombre_usuario'=>$row['nombre_usuario'],'email_user'=>$row['email_user'], 'telefono_user'=>$row['telefono_user'], 'urlPerfil'=>imagePerfil($row['id_usuario'], true)   ];
        }

        $data['mensage'] = ['mensageType' => 1, 'mensageText' => 'Datos usuario obtenidos correctamente'];

    } catch (PDOException $e) {
        $data['mensage'] = ['mensageType' => 3, 'mensageText' => 'El nick introducido no esta disponible'];
        echo json_encode($data);
        exit();
    }
    echo json_encode($data);




?>