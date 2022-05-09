<?php

function html($text)
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function imagePerfil($id_usuario, $user)
{
    // convertir id a numero 
    $id_usuario = intval($id_usuario);

    // montra ruta del servidor 
    $url = ($user) ?  $_SERVER['DOCUMENT_ROOT'] . "/api/img/usuarios/" . $id_usuario . "/" :  $_SERVER['DOCUMENT_ROOT'] . "/api/img/locales/" . $id_usuario . "/";


    // comprovar si existe la ruta
    $dirint = dir($url);
    $archivo = "";
    $perfil = false;

    try {
        // recorrer documentos
        while (($documentos = $dirint->read()) != false) {
            
            $search = "perfil";
            // comprobar si es un perfil 
         //   if (strpos($documentos, "perfil")) {
if (            preg_match("/{$search}/i", $documentos)){
                // comprobar si es la imagen
                if (strpos($documentos, 'jpg') || strpos($documentos, 'jpeg') || strpos($documentos, 'png')) {
                    // montar ruta cliente

                    // RUTA DEL SERVIDORURL_IMG_LOCAL
                    $archivo = ($user) ? URL_SERVER . URL_USUARIO_IMG . $id_usuario . BARRA . $documentos : URL_SERVER . URL_IMG_LOCAL . $id_usuario . BARRA . $documentos;


                    $perfil = true;
                    break;
                }
            }
        }
        // cerrar directorio
        $dirint->close();
    } catch (Exception $e) {
    }


    if (!$perfil) {
        $archivo = "https://eduardobuleodaw.000webhostapp.com/api/img/utilidades/noPerfil/noImage.png";
    }


    return $archivo;
}
function carruselImagenes($id_usuario)
{
    // convertir id a numero 
    $id_usuario = intval($id_usuario);


    // montra ruta del servidor 
    $url = $_SERVER['DOCUMENT_ROOT'] . URL_LOCAL . $id_usuario . BARRA;

    // comprovar si existe la ruta
    $dirint = dir($url);
    $archivo = "";
    $rutas = [];
    $index = 0;
    try {
        // recorrer documentos
        while (($documentos = $dirint->read()) != false) {

            if (strpos($documentos, 'jpg') || strpos($documentos, 'jpeg') || strpos($documentos, 'png')) {

                $archivo = URL_SERVER . URL_IMG_LOCAL . $id_usuario . BARRA . $documentos;

                // $rutas[] = array('archivo' =>$archivo, 'id' => $index ) ;
                $rutas[] = $archivo;
                $index = $index + 1;
            }
        }
        // cerrar directorio
        $dirint->close();
    } catch (Exception $e) {
    }


    if (count($rutas) == 0) {
        $rutas[] = NO_IMAGE;
    }

    return $rutas;
}
