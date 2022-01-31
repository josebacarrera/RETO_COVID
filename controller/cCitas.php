<?php
include_once('../model/citaModel.php');
error_reporting(E_ERROR | E_WARNING | E_PARSE); // <-- Esto solo muestra errores de ejecución

$response = array();
$data=json_decode(file_get_contents("php://input"),true);

if (isset($data['solicitud'])) {
    $solicitud=$data['solicitud'];
    $response['error'] = false;
    
    switch ($solicitud) {

        //@Param: tis

        case 'selectAllCitasByTis':

            if (isset($data['tis'])) {$tis=$data['tis'];}
            else {$response['error'] = true;$response['errorInf'] = 'Tis Not Found';}

            if (!$response['error']) { // Ejecución realizado una vez combrobado que no hay errores en recibir los datos.
                $citas = new citaModel();
                $citas->setTis_paciente($tis);
                $response['citas'] = $citas->selectAllByTis();
            }
            break;

        //@Param: fecha, centro

        case 'selectHoraByFechaCentro':

            if (isset($data['fecha'])) {$fecha=$data['fecha'];}
            else {$response['error'] = true;$response['errorInf'] = 'Fecha Not Found';}

            if (isset($data['centro'])) {$centro=$data['centro'];}
            else {$response['error'] = true;$response['errorInf'] = 'Centro Not Found';}

            if (!$response['error']) { // Ejecución realizado una vez combrobado que no hay errores en recibir los datos.
                $citas = new citaModel();
                $citas->setFecha($fecha);
                $citas->setCod_centro($centro);
                $response['horasOcupadas'] = $citas->selectHoraByFechaCentro();
            }
            break;
    }
    
        
} else {
    $response['error'] = true;
    $response['errorInf'] = 'Solicitud Not Found';
}

echo json_encode($response);
unset($response);