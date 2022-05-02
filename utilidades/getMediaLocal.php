<?php
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/helpers.inc.php';

$id_local = (isset($_GET['id_local'])) ? (html($_GET['id_local'])) : 0;

$datos = [ 'datos'     => [ 'puntuacion'=> 0 ],'mensage'   => [] ];


