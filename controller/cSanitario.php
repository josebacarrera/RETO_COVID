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

            //Se escribe el archivo
            //file_put_contents($writable_dir.$cartel, $file,  LOCK_EX);

            if (isset($data['dni'])) {$dni=$data['dni'];}
            else {$response['error'] = true;$response['errorInf'] = 'Dni Not Found';}

            if (isset($data['nombre'])) {$nombre=$data['nombre'];}
            else {$response['error'] = true;$response['errorInf'] = 'Nombre Not Found';}
            
            if (isset($data['apellido'])) {$apellido=$data['apellido'];}
            else {$response['error'] = true;$response['errorInf'] = 'Apellido Not Found';}

            if (isset($data['filename'])) 
            {               

                $writable_dir = '../view/img/';
                $cartel=$data['filename'];

                $savedFileBase64=$data['savedFileBase64'];
                $fileBase64 = explode(',', $savedFileBase64)[1]; //parte dcha de la coma

                $file = base64_decode($fileBase64);
                if(!is_dir($writable_dir)){mkdir($writable_dir);}

                $extension = pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION);
            
                $new_name = time() . '.' . $extension;
            
                file_put_contents($writable_dir.$foto_perfil, $foto_perfil,  LOCK_EX);
            

                $sanitario->setNombre($nombre);
                $sanitario->setApellido($apellido);
                $sanitario->setFoto_pefil($cartel);

                $response['newSanitario'] = $sanitario->ObjVars();

            }
            break;
    }
} else {
    $response['error'] = true;
    $response['errorInf'] = 'Solicitud Not Found';
}

echo json_encode($response);
unset($response);
