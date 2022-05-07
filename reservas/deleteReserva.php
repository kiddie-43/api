<?php
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/helpers.inc.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/informacionLocal.php';
// $json = file_get_contents('php://input');
// $params = json_decode($json);

$id_reserva = html($_GET['id_reserva']);


$data = [
    'data'      => [],
    'mensage'   => []

];


try {
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';

    $query = "DELETE FROM `reserva` WHERE `id_reserva` = :id;";

    $result = $pdo->prepare($query);

  

    $result->bindValue(':id', $id_reserva);
    $result->execute();

    $data['mensage'] = ['mensageType' => 1, 'mensageText' => 'Reserva eliminada'];
} catch (PDOException $e) {
    $error = 'Unable to connect to the database server.';
    $data['mensage'] = ['mensageType'=>3, 'mensageText'=>'No se puede obtener los datos del usuario'];
    exit();
}

