<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/helpers.inc.php';

$id_comentario = html($_GET['id_comentario']);
//DELETE FROM `comentarios` WHERE comentarios.id_comentario = 2

try {
    
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';
    
    $query = "DELETE FROM `comentarios` WHERE comentarios.id_comentario = :id";
    
    $result = $pdo->prepare($query);

    $result->bindValue(':id', $id_comentario);
    
    $result->execute();

    $data['mensage'] = ['mensageType'=> 1, 'mensageText'=>'Comentario borrado'];
 
} catch (PDOException $e) {
    
    $data['mensage'] = ['mensageType'=> 3, 'mensageText'=>'No ha sido posible eliminar tu comentario'];

}

echo json_encode($data);