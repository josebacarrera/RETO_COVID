<?php
require_once ("../model/userModel.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE); // <-- Esto solo muestra errores de ejecución

$response = array();
$data=json_decode(file_get_contents("php://input"),true);


// Bloque de Datos Recibidos

$response['error'] = false;

if (isset($data['solicitud'])) {
    $solicitud=$data['solicitud'];
} else {
    $response['error'] = 'true';
    $response['errorInf'] = 'Solicitud Not Found';
}

if (isset($data['usuario'])) {
    $usuario=$data['usuario'];
} else {
    $response['error'] = 'true';
    $response['errorInf'] = 'User Not Found';
}

if (isset($data['password'])) {
    $password=$data['password'];
} else {
    $response['error'] = 'true';
    $response['errorInf'] = 'Password Not Found';
}

// FIN Bloque de Datos Recibidos

if (!$response['error']) { // Ejecución realizado una vez combrobado que no hay errores en recibir los datos.
    $response['debug'] = 'Testing';

    $user = new userModel();
    
    if ($solicitud == 'LogDNI') {
        $user->setDni_sanitario($usuario);
        $user->setPassword($password);
        $user->loginDNI();
    }

}

$response['user'] = $user->ObjVars();


echo json_encode($response);

?>