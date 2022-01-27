<?php
require_once ("../model/userModel.php");
require_once ("../model/datosPacienteModel.php");
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

            // @Param: dni, password

            if (isset($data['dni'])) {$dni=$data['dni'];}
            else {$response['error'] = true;$response['errorInf'] = 'User Not Found';}
            
            if (isset($data['password'])) {$password=$data['password'];} 
            else {$response['error'] = true;$response['errorInf'] = 'Password Not Found';}

            if (!$response['error']) { // Ejecución realizado una vez combrobado que no hay errores en recibir los datos.

                $user = new userModel();
                $user->setDni_sanitario($dni);
                $user->setPassword($password);

                if ($user->loginDNI()) {
                    session_start();
                    $response['logged'] = true;
                    $response['user'] = $user->ObjVars();

                    $_SESSION['cod_user'] = $user->getCod();
                    $_SESSION['rol'] = $user->ObjVars()['objRol']['nombre'];
                    $_SESSION['sanitario'] = $user->ObjVars()['objSanitario'];

                } else {
                    $response['error'] = true;
                    $response['errorInf'] = 'Wrong User or Password';
                }    
            
            }

            break;

        case 'loginTis':

            // @Param: tis, fecha_nac

            if (isset($data['tis'])) {$tis=$data['tis'];} 
            else {$response['error'] = true;$response['errorInf'] = 'User Not Found';}
            
            if (isset($data['fecha_nac'])) {$fecha_nac=$data['fecha_nac'];} 
            else {$response['error'] = true;$response['errorInf'] = 'Password Not Found';}

            if (!$response['error']) { // Ejecución realizado una vez combrobado que no hay errores en recibir los datos.

                $paciente = new datosPacienteModel();
                $paciente->setTis($tis);
                $paciente->setFecha_nacimiento($fecha_nac);

                if ($paciente->loginTIS()) {
                    session_start();
                    $response['logged'] = true;
                    $response['paciente'] = $paciente->ObjVars();
                    $_SESSION['rol'] = 'paciente';
                    $_SESSION['paciente'] = $paciente->ObjVars();

                } else {
                    $response['error'] = true;
                    $response['errorInf'] = 'Wrong User or Password';
                }    
            
            }
            break;

        case 'logout':
            session_start();
            $response['Inf'] = "Session eliminada correctamente";
            session_unset();
            session_destroy();
            break;
        
        default:
            session_start();
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
unset($response);

?>