<?php
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/helpers.inc.php';

$json = file_get_contents('php://input');
$params = json_decode($json);


$id_local = intVal(html($params->idLocal));
$id_usuario = intVal(html($params->idUsuario));
$decripcion = html($params->descripcion);
$puntuacion = intVal(html($params->puntuacion));


$data = [
    'datos'     => [],
    'mensage'   => []
];



try {

    // conexion base de datos
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';
    // Montar query
    $query = "INSERT INTO `comentarios`( `id_local`, `id_usuario`, `comentario`, `puntuacion`, `fechaComentario`) VALUES ('$id_local','$id_usuario','$decripcion','$puntuacion', CURDATE())";
    // Realizar peticion al server
    $result = $pdo->prepare($query);
    $result->execute();

    $data['mensage'] = ['mensageType'=> 1, 'mensageText'=>'Comentario publicado'];
 
} catch (PDOException $e) {
    $data['mensage'] = ['mensageType'=> 3, 'mensageText'=>'No ha sido posible publicar tu comentario'];

}
echo json_encode($data);