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
            $foto_perfil=$data['foto_perfil'];

            //Se escribe el archivo
            //file_put_contents($writable_dir.$cartel, $file,  LOCK_EX);

            if (isset($data['dni'])) {$dni=$data['dni'];}
            else {$response['error'] = true;$response['errorInf'] = 'Dni Not Found';}

            if (isset($data['nombre'])) {$nombre=$data['nombre'];}
            else {$response['error'] = true;$response['errorInf'] = 'Nombre Not Found';}
            
            if (isset($data['apellido'])) {$apellido=$data['apellido'];}
            else {$response['error'] = true;$response['errorInf'] = 'Apellido Not Found';}


            if(isset($_FILES['foto_perfil']))
            {
            
                $imgNombre=$data['nombreImg'].'.'.end(explode('.',$foto_perfil));
                $foto_perfil=$_FILES['foto_perfil'];
                $writable_dir = '../view/img/';
                $extension=end(explode('.',$foto_perfil));

                var_dump($imgNombre);
                if(!is_dir($writable_dir)){mkdir($writable_dir);}

                $extension = pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION);
            
                $new_name = time() . '.' . $extension;
            
                file_put_contents($writable_dir.$foto_perfil, $foto_perfil,  LOCK_EX);
            

                echo json_encode($data);
            
            }
      
            else {$foto_perfil = NULL;}

            if (!$response['error']) { // Ejecución realizado una vez combrobado que no hay errores en recibir los datos.
                $sanitario = new sanitarioModel();
                $sanitario->setDni($dni);
                $sanitario->setNombre($nombre);
                $sanitario->setApellido($apellido);
                $sanitario->setFoto_pefil($foto_perfil);

                $response['error']=$sanitario->update();
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
