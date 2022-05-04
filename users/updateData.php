<?php

// incluir variables externas 
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/routs.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/helpers.inc.php';


// obtener los datos angular
$json = file_get_contents('php://input');
$params = json_decode($json);

$nick_user = html ($params->nickUser);
$name = html ($params->nombreUser);
$telefono = html($params->telefonoUser);
$email = html($params->emailUser) ;
$id_user = intval( html($params->id_usuario));
$cambios = false;
$update= 'UPDATE `users` SET ';
$condicion = '';
$where = 'WHERE `id_usuario` = :id"';

$datosRegistrados = cargarDatosDelUsuario($id_user);


if ($datosRegistrados['nombre'] != $name ){
    $condicion= $condicion.'`nombre_usuario`=:name';
    $cambios = true;
}
if ($datosRegistrados['nick'] != $nick_user) {
    $cambios = true;

    try {

        include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';
        $query = "SELECT count(*) as registrado from usuarios where nombre_publico = :nick";
        $result = $pdo->prepare($query);
        $result->bindValue(':nick', $nick_user);
        $result->execute();
    
        foreach ($result as $row) {
            $temporal = ($row['registrado'] != 0) ? true : false;
        }
    
    } catch (PDOException $e) {
        
        $data['mensage'] = ['mensageType' => 3, 'mensageText' => 'El nick introducido no esta disponible'];
        echo json_encode($data);
        exit();
    
    }
    
    if ($temporal) {
    
        $data['mensage'] = ['mensageType' => 3, 'mensageText' => 'El nick introducido no esta disponible'];
        echo json_encode($data);
        exit();
    
    } else {
        if ($condicion != ''){
            $condicion =$condicion . ', `nombre_publico`=:nick' ;
        }else {
            $condicion =$condicion . '`nombre_publico`=:nick' ;
        }
    }
}

if ($datosRegistrados['email'] != $email) {
    $cambios = true;

    try {

        $query = "SELECT count(*) as registrado from  usuarios where email_user = :email";
        $result = $pdo->prepare($query);
        $result->bindValue(':email', $email);
        $result->execute();

        foreach ($result as $row) {
            $temporal = ($row['registrado'] != 0) ? true : false;
        }

    } catch (PDOException $e) {

        $data['mensage'] = ['mensageType' => 3, 'mensageText' => 'El email introducido no esta disponible'];
        echo json_encode($data);
        exit();

    }

    if ($temporal) {
        $data['mensage'] = ['mensageType' => 3, 'mensageText' => 'El email introducido no esta disponible'];
        echo json_encode($data);
        exit();
    }else {
    
    if ($condicion != ''){
        $condicion =$condicion . ',`email_user`=:email';
    } else {
        $condicion =$condicion . '`email_user`=:email';
    }
   
}

}
if ($datosRegistrados['telefono'] != $telefono) {
    $cambios = true;

    try {
        
        $query = "SELECT count(*) as registrado from  usuarios where telefono_user = :telefono";


        $result = $pdo->prepare($query);
        $result->bindValue(':telefono', $telefono );
        $result->execute();

        foreach ($result as $row) {
            $temporal = ($row['registrado'] != 0) ? true : false;
        }
    } catch (PDOException $e) { 
        $data['mensage'] = ['mensageType' => 3, 'mensageText' => 'El telefono introducido no esta disponible'];
        echo json_encode($data);
        exit();
    }

    if ($temporal) {
        $data['mensage'] = ['mensageType' => 3, 'mensageText' => 'El telefono introducido no esta disponible'];
        echo json_encode($data);
        exit();
    }else {
    
        if ($condicion != ''){
            $condicion =$condicion . ', `telefono_user`=:telefono';   
        }else {
            $condicion =$condicion . '`telefono_user`=:telefono'; 
        }
            
    }
}


if ( $cambios ){
    try {

        include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';
       
        $query = "UPDATE `usuarios` SET `nombre_usuario`=:name,`nombre_publico`=:nick,`telefono_user`=:telefono,`email_user`=:email WHERE `id_usuario` = :id";
        
        $result = $pdo->prepare($query); 
        $result->bindValue(':name', $name);
        $result->bindValue(':nick', $nick_user);
        $result->bindValue(':telefono', $telefono);
        $result->bindValue(':email', $email);
        $result->bindValue(':id', $id_user);
        $result->execute();
            
        $data['mensage'] = ['mensageType' => 1, 'mensageText' => 'Datos del usuario actualizados'];
     
            
    
    
    } catch (PDOException $e) { }
            echo json_encode( $data );
    
}


//******************************************************************************************************************************************* */
//******************************************************************************************************************************************* */
//******************************************************************************************************************************************* */
//******************************************************************************************************************************************* */
//******************************************************************************************************************************************* */
//******************************************************************************************************************************************* */
//******************************************************************************************************************************************* */
//******************************************************************************************************************************************* */
//******************************************************************************************************************************************* */
//******************************************************************************************************************************************* */
//******************************************************************************************************************************************* */
//******************************************************************************************************************************************* */
//******************************************************************************************************************************************* */
//******************************************************************************************************************************************* */
function cargarDatosDelUsuario($id_usuario){
    $datosUsuario = [];
    try {

        // conexion base de datos
        include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/db.inc.php';
        // Montar query
       
        //UPDATE `usuarios` SET `nombre_usuario`='pruebas',`nombre_publico`='pruebas cambiohhh',`telefono_user`='211213132',`email_user`='pruebaees@gmail.com' WHERE `id_usuario` = $id_user;
        //$query = "UPDATE `usuarios` SET `nombre_usuario`='$name',`nombre_publico`='$nick_user',`telefono_user`='$telefono',`email_user`='$email' WHERE `id_usuario` = $id_user";
        $query = "    SELECT  `nombre_usuario`, `nombre_publico`,`telefono_user`, `email_user` FROM `usuarios` WHERE `id_usuario` = :id";
        
        $result = $pdo->prepare($query); 
        $result->bindValue(':id', $id_usuario);
        $result->execute();
            
      foreach ( $result as $row ) {
        $datosUsuario = ['nombre'=> $row['nombre_usuario'], 'nick'=>$row['nombre_publico'], 'telefono'=>$row['telefono_user'], 'email'=>$row['email_user']];
      }
     
            
    
    
    } catch (PDOException $e) { }
return $datosUsuario;
}