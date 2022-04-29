<?php


if (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp')){
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs_local.php';
} else {
    include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs_online.php';
}