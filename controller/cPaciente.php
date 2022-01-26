<?php
include_once('../model/datosPacienteModel.php');
error_reporting(E_ERROR | E_WARNING | E_PARSE); // <-- Esto solo muestra errores de ejecución

$response = array();
$data=json_decode(file_get_contents("php://input"),true);

if (isset($data['solicitud'])) {
    $solicitud=$data['solicitud'];
    $response['error'] = false;
    
    switch ($solicitud) {

        //@Param: nombre, apellido, fecha_nac, email, localidad

        case 'insertPaciente':

            if (isset($data['nombre'])) {$nombre=$data['nombre'];}
            else {$response['error'] = true;$response['errorInf'] = 'Nombre Not Found';}

            if (isset($data['apellido'])) {$apellido=$data['apellido'];}
            else {$response['error'] = true;$response['errorInf'] = 'Apellido Not Found';}
            
            if (isset($data['fecha_nac'])) {$fecha_nac=$data['fecha_nac'];}
            else {$response['error'] = true;$response['errorInf'] = 'Apellido Not Found';}

            if (isset($data['email'])) {$email=$data['email'];}
            else {$response['error'] = true;$response['errorInf'] = 'Email Not Found';}

            if (isset($data['localidad'])) {$localidad=$data['localidad'];}
            else {$response['error'] = true;$response['errorInf'] = 'Localidad Not Found';}


            if (!$response['error']) { // Ejecución realizado una vez combrobado que no hay errores en recibir los datos.
                $paciente = new datosPacienteModel();
                $paciente->setNombre($nombre);
                $paciente->setApellido($apellido);
                $paciente->setFecha_nacimiento($fecha_nac);
                $paciente->setEmail($email);
                $paciente->setCod_localidad($localidad);

                if ($paciente->insert()) {

                    if ($paciente->loginTIS()) {
                        session_start();
                        $response['paciente'] = $paciente->ObjVars();
    
                    } else {
                        $response['error'] = true;
                        $response['errorInf'] = 'Wrong TIS';
                    }  

                } else {
                    $response['error'] = true;
                    $response['errorInf'] = 'SQL Fail';
                }
                
            }
            break;
    }
} else {
    $response['error'] = true;
    $response['errorInf'] = 'Solicitud Not Found';
}

echo json_encode($response);