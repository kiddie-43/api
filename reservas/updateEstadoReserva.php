<?php

include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/helpers.inc.php';


$id_reserva = html($_GET['id_reserva']);
$id_estado = html($_GET['id_estado']);
$data = [
    'data' => [], 'mensage' => []
];

try {

    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';
    $query = "UPDATE `reserva` SET `id_estado`=:id_estado WHERE id_reserva = :id_reserva ";
    $result = $pdo->prepare($query);
    $result->bindValue(':id_estado', $id_estado);
    $result->bindValue(':id_reserva', $id_reserva);
    $result->execute();


    $data['mensage'] = ['mensageType' => 1,  'mensageText' => 'datos obtenidos'];
} catch (PDOException $e) {
    $data['mensage'] = ['mensageType' => 3,  'mensageText' => 'No se pueden obtener los datos de si el usuario es hostelero.'];
    echo json_encode($data);
    exit();
}

echo json_encode($data);
exit();


    //UPDATE `reserva` SET `id_estado`='1' WHERE id_reserva = 1 