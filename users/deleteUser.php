<?php
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/helpers.inc.php';

$id_usuario = html( $_GET['id_usuario']);
echo $id_usuario;
$data = [
    'data'      => [], 
    'mensage'   => []
];
// $aux = count($id_usuario);
if ($id_usuario == '' ){
    $data['mensage'] = ['mensageType' => 3, 'mensageText' => 'Usuario no introducido'];
    echo json_encode($data);
    exit();

}



try {

    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';
    $query = "DELETE FROM `usuarios` WHERE `usuarios`.`id_usuario` = :id";
    $result = $pdo->prepare($query);
    $result->bindValue(':id', $id_usuario);
    $result->execute();


$ruta = $_SERVER['DOCUMENT_ROOT']   . '/api/img/usuarios/'.$id_usuario.'/';

if (is_dir($ruta)) {
    rmdir($ruta);    
}

$data['mensage'] = ['mensageType' => 1, 'mensageText' => 'Usuario borrado correctamente'];


} catch (PDOException $e) {
    $data['mensage'] = ['mensageType' => 3, 'mensageText' => 'No ha sido posible borrar el usuario '];
    echo json_encode($data);
    exit();
}


echo json_encode($data);
exit();