<?php


include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/helpers.inc.php';
$json = file_get_contents('php://input');
$params = json_decode($json);


$comentario = html($params->comentario);
$puntuacion = html($params->puntuacion);
$id_comentario = html($params->id_comentario);



//UPDATE `comentarios` SET `comentario`=,`puntuacion`=,`fechaComentario`= WHERE 1

try {
    
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';
    
    $query = "UPDATE `comentarios` SET `comentario`=:comentario,`puntuacion`=:puntuacion,`fechaComentario`=CURDATE() WHERE  comentarios.id_comentario = :id";
    
    $result = $pdo->prepare($query);

    $result->bindValue(':id', $id_comentario);
    $result->bindValue(':comentario', $comentario);
    $result->bindValue(':puntuacion', $puntuacion);
    $result->execute();

    $data['mensage'] = ['mensageType'=> 1, 'mensageText'=>'Comentario actualizado'];
 
} catch (PDOException $e) {
    
    $data['mensage'] = ['mensageType'=> 3, 'mensageText'=>'No ha sido posible editar tu comentario'];

}

echo json_encode($data);