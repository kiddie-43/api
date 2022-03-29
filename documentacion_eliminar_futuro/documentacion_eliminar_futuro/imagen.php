<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('content-type: application/json; charset=utf-8');
const URL = "http://dws.local/api/";


$id_usuario = intval($_GET['id_local']);


// Establecer ruta local server
$url = $_SERVER['DOCUMENT_ROOT'] . '/api/img/locales/' . $id_usuario . "/";

//http://dws.local/api/img/locales/2/perfil.jpg

$dirint = dir($url); // ver si la ruta esta definica
$archivo = "";
$perfil = false; // no tiene perfil por defecto





try {
    // si la ruta existe abrirla i leerla
    while (($documentos = $dirint->read()) != false) {

        if (str_contains($documentos, "perfil")) { // si el archivo es el perfil

            if (strpos($documentos, 'jpg') || strpos($documentos, 'jpeg') || strpos($documentos, 'png')) { // si el documento es una imagen 

                //$archivo = $url . $documentos;
                // montar ruta
                $archivo = URL . 'img/locales/' . $id_usuario . "/" . $documentos;
                // tiene perfil
                $perfil = true;
                break;
            }
        }
    }
    // cerrar directorio
    $dirint->close();
} catch (Exception $e) {
}
// comprobar si esta para en caso de que no mandar un general 
$archivo = ($perfil ?  $archivo : URL . "img/locales/noperfil.jpg");
// montar array json
$data = ['url' => $archivo];
// mandar datos al usuario 
echo json_encode($data);









// function encontrarImagen($id_usuario)
// {
//     $url = URL . "img/locales/" . $id_usuario;

//     $dirint = dir($url);
//     $image = "";
//     $perfil = false;

//     try {
//         while (($archivo = $dirint->read()) != false) {

//             if (str_contains($archivo, "perfil")) {
//                 if (strpos($archivo, 'jpg') || strpos($archivo, 'jpeg') || strpos($archivo, 'png')) {

//                     $image = $url . $archivo;
//                     $perfil = true;
//                     break;
//                 }
//             }
//         }
//         $dirint->close();
//     } catch (Exception $e) {
//     }


//     return ($perfil ?  $image : URL . "img/locales/noperfil.jpg");
// }
