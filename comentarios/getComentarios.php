<?php
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/helpers.inc.php';


$id_local = html($_GET['id_local']);





    $data = [
        'data'=> ['comentarios' => [], 'valoracion' => 0 ], 
        'mensage' => [
            'mensageType' =>0,
            'mensageText'=> ''
        ]
    ]; 

    
    try {
        include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';
        $query = "SELECT comentarios.id_comentario as id, comentarios.comentario as comentario, comentarios.puntuacion as valoracion, usuarios.nombre_usuario as nombre_usuario, usuarios.id_usuario as id_usuario FROM locales , comentarios inner join usuarios on comentarios.id_usuario = usuarios.id_usuario WHERE locales.id_local = :id ORDER BY comentarios.id_comentario DESC; ";
        $result = $pdo->prepare($query);
        $result->bindValue(':id', $id_local);

        $result->execute();
    } catch (PDOException $e) {
        $data ['mensage']['mensajeType'] = 3;
        $data ['mensage']['mensajeText'] = 'No ha sido posible obtener los comentarios';
        echo json_encode($data);
        exit();
    }

    foreach ($result as $row) {

        $data['data']['comentarios'][] = array(
            'id' => $row['id'], 'comentario' => $row['comentario'], 'valoracion' => $row['valoracion'], 'nombre_usuario' => $row['nombre_usuario'], 'id_usuario' => $row['id_usuario'], 'perfil' => imagePerfil($row['id_usuario'], true)
        );
        // , 'perfil'=> imagePerfil($row['id_usuario'], true)
    }


   
    echo json_encode($data);











function obtenerMedia($id_local){
    
    // SELECT AVG(comentarios.puntuacion)*10 as media FROM `comentarios` WHERE id_local = 2;
    $data = 0;

    try {
        include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';

        $query = "SELECT  AVG(comentarios.puntuacion)*10 as media FROM `comentarios` WHERE id_local = :id;";
        $result = $pdo->prepare($query);
        $result->bindValue(':id', $id_local);

        $result->execute();
    } catch (PDOException $e) {
        $error = 'Unable to connect to the database server.';
    }

    foreach ($result as $row) {

        $data['data']['valoracion'] = intVal($row['media']);
        
    }

   




   // return ($nota / $comentarios) * 10;
}
