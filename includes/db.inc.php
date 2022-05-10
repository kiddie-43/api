<?php
$user = $pass = $database = '';
$user = 'root';
$pass = '';
$database = 'blup';
// $user = 'id18276420_blup_user';
// $pass = '(2JNYcR4(=W1vNAm';
// $database = 'id18276420_blup';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=$database", $user, $pass);
} catch (PDOException $e) {

    $error = 'Unable to connect to the database server.';
    include $_SERVER['DOCUMENT_ROOT'] . '/assets/includes/error.html.php';
    exit();

}


