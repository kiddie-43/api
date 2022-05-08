<?php
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/helpers.inc.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/informacionLocal.php';
$json = file_get_contents('php://input');
$params = json_decode($json);

$carta = html($params->id_local);
$descripcion = html($params->id_usuario);
$descripcion_zona = html($params->numPersonas);


$data = [
    'datos'     => [],
    'mensage'   => []
];


try {

    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';
    $query = "SELECT id_local, nombre_local FROM locales where id_local = :id";
    $result = $pdo->prepare($query);
    $result->bindValue(":id", $id_local);
    $result->execute();
    if ($id_local > 0) {
        $data['mensage'] = ['mensageType' => 1,  'mensageText' => 'datos obtenidos'];
    }
} catch (PDOException $e) {
    $data['mensage'] = ['mensageType' => 3,  'mensageText' => 'No se pueden obtener los datos del local.'];
    echo json_encode($data);
    exit();
}
