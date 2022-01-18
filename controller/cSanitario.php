<?php
include_once('../model/sanitarioModel.php');
error_reporting(E_ERROR | E_WARNING | E_PARSE); // <-- Esto solo muestra errores de ejecución

$response = array();
$data=json_decode(file_get_contents("php://input"),true);

if (isset($data['solicitud'])) {
    $solicitud=$data['solicitud'];
    $response['error'] = false;
    
    switch ($solicitud) {

        case 'updateSanitario':

            if (isset($data['dni'])) {$dni=$data['dni'];}
            else {$response['error'] = true;$response['errorInf'] = 'Dni Not Found';}

            if (isset($data['nombre'])) {$nombre=$data['nombre'];}
            else {$response['error'] = true;$response['errorInf'] = 'Nombre Not Found';}
            
            if (isset($data['apellido'])) {$apellido=$data['apellido'];}
            else {$response['error'] = true;$response['errorInf'] = 'Apellido Not Found';}

            if (isset($data['fotoPerfil'])) {$fotoPerfil=$data['fotoPerfil'];}
            else {$response['error'] = true;$response['errorInf'] = 'FotoPerfil Not Found';}

            if (!$response['error']) { // Ejecución realizado una vez combrobado que no hay errores en recibir los datos.
                $sanitario = new sanitarioModel();
                $sanitario->setDni($dni);
                $sanitario->setNombre($nombre);
                $sanitario->setApellido($apellido);
                $sanitario->setFoto_pefil($fotoPerfil);
                $sanitario->update();
                $response['newSanitario'] = $sanitario->ObjVars();
            }
            break;
    }
} else {
    $response['error'] = true;
    $response['errorInf'] = 'Solicitud Not Found';
}