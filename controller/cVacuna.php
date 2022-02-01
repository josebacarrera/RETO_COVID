<?php
include_once('../model/vacunaModel.php');
error_reporting(E_ERROR | E_WARNING | E_PARSE); // <-- Esto solo muestra errores de ejecución

$response = array();
$data=json_decode(file_get_contents("php://input"),true);

if (isset($data['solicitud'])) {
    $solicitud=$data['solicitud'];
    $response['error'] = false;
    
    switch ($solicitud) {

        //@Param: cod, nombre, max, intervalo

        case 'updateVacuna':

            if (isset($data['cod'])) {$cod=$data['cod'];}
            else {$respons['error']=true;$response['errorInf']='Cod Not Found';}

            if (isset($data['nombre'])) {$nombre=$data['nombre'];}
            else {$respons['error']=true;$response['errorInf']='Nombre Not Found';}

            if (isset($data['intervalo'])) {$intervalo=$data['intervalo'];}
            else {$respons['error']=true;$response['errorInf']='Intervalo Not Found';}

            if (isset($data['max'])) {$max=$data['max'];}
            else {$respons['error']=true;$response['errorInf']='Max Not Found';}

            if (!$response['error']) { // Ejecución realizado una vez combrobado que no hay errores en recibir los datos.

                $vacuna = new vacunaModel();
                $vacuna->setCod($cod);
                $vacuna->setNombre($nombre);
                $vacuna->setMax($max);
                $vacuna->setIntervalo($intervalo);

                if ($vacunacion->update()) {
                    $response['newVacuna'] = $vacuna->ObjVars();
                } else {
                    $response['error'] = true;
                    $response['errorInf'] = 'Wrong Tis or BBDD';
                }

            }

        break;

        //@Param: cod, nombre, max, intervalo

        case 'addVacuna':
        
           

            if (isset($data['nombre'])) {$nombre=$data['nombre'];}
            else {$respons['error']=true;$response['errorInf']='Nombre Not Found';}

            if (isset($data['intervalo'])) {$intervalo=$data['intervalo'];}
            else {$respons['error']=true;$response['errorInf']='Intervalo Not Found';}

            if (isset($data['max'])) {$max=$data['max'];}
            else {$respons['error']=true;$response['errorInf']='Max Not Found';}

            if (!$response['error']) { // Ejecución realizado una vez combrobado que no hay errores en recibir los datos.

                $vacuna = new vacunaModel();
                $vacuna->setNombre($nombre);
                $vacuna->setMax($max);
                $vacuna->setIntervalo($intervalo);

                if ($vacuna->insert()) {
                    $response['newVacuna'] = $vacuna->ObjVars();
                } else {
                    $response['error'] = true;
                    $response['errorInf'] = 'Wrong Tis or BBDD';
                }

            }

        break;

        case'setListVacunas':
            $vacunas=new vacunaModel();
            $response['vacunas'] = $vacunas->setList(); 
        break;

    }
} else {
    $response['error'] = true;
    $response['errorInf'] = 'Solicitud Not Found';
}

echo json_encode($response);
unset($response);