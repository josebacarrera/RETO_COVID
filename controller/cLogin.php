<?php
require_once ("../model/userModel.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE); // <-- Esto solo muestra errores de ejecución

$response = array();
$data=json_decode(file_get_contents("php://input"),true);

// Bloque de Solicitud
// Existen 3 solicitudes: loginDni, loginTis, logout
// En caso de entroducir cualquier solicitud no admitida logout

if (isset($data['solicitud'])) {
    $solicitud=$data['solicitud'];
    $response['error'] = false;
    
    switch ($solicitud) {

        case 'loginDni':
        case 'loginTis': 

            if (isset($data['usuario'])) {
                $usuario=$data['usuario'];
            } else {
                $response['error'] = true;
                $response['errorInf'] = 'User Not Found';
            }
            
            if (isset($data['password'])) {
                $password=$data['password'];
            } else {
                $response['error'] = true;
                $response['errorInf'] = 'Password Not Found';
            }

        case 'loginDni':

            if (!$response['error']) { // Ejecución realizado una vez combrobado que no hay errores en recibir los datos.

                $user = new userModel();
                $user->setDni_sanitario($usuario);
                $user->setPassword($password);

                if ($user->loginDNI()) {
                    session_start();
                    $response['logged'] = true;
                    $response['user'] = $user->ObjVars();
                } else {
                    $response['error'] = true;
                    $response['errorInf'] = 'Wrong User or Password';
                }    
            
            }

            break;

        case 'loginTis':
            // PROXIMAMENTE...
            break;

        case 'logout':
            $response['Inf'] = "Session eliminada correctamente";
            session_unset();
            session_destroy();
            break;
        
        default:
            $response['error'] = true;
            $response['errorInf'] = "Session eliminada, acceso no autorizado";
            session_unset();
            session_destroy();
            break;
    }

} else {
    $response['error'] = true;
    $response['errorInf'] = 'Solicitud Not Found';
}

// FIN Bloque de Solicitud

echo json_encode($response);

?>