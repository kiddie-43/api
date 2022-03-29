<?php
$user = $pass = $database = '';
$user = 'root';
$pass = '';
$database = 'blup';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=$database", $user, $pass);
} catch (PDOException $e) {

    $error = 'Unable to connect to the database server.';
    include $_SERVER['DOCUMENT_ROOT'] . '/assets/includes/error.html.php';
    exit();

}


