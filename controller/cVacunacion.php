<?php
include_once('../model/RegistroVacunacionModel.php');
error_reporting(E_ERROR | E_WARNING | E_PARSE); // <-- Esto solo muestra errores de ejecución

$response = array();
$data=json_decode(file_get_contents("php://input"),true);

if (isset($data['solicitud'])) {
    $solicitud=$data['solicitud'];
    $response['error'] = false;
    
    switch ($solicitud) {

        //@Param: tis

        case 'getRegVacunacion':

            if (isset($data['tis'])) {$tis=$data['tis'];}
            else {$respons['error']=true;$response['errorInf']='Tis Not Found';}

            if (!$response['error']) { // Ejecución realizado una vez combrobado que no hay errores en recibir los datos.

                $vacunacion = new registroVacunacionModel();
                $vacunacion->setTis($tis);

                if ($vacunacion->getRegistroVacunacion()) {
                    $response['registroVacunacion'] = $vacunacion->ObjVars();
                } else {
                    $response['error'] = true;
                    $response['errorInf'] = 'Wrong Tis or BBDD';
                }

            }

        break;
    }
} else {
    $response['error'] = true;
    $response['errorInf'] = 'Solicitud Not Found';
}

echo json_encode($response);