<?php
session_start();

include_once ("../model/userModel.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE); // <-- Esto solo muestra errores de ejecución
$response = array();

if (empty($_SESSION)) {
    $_SESSION['status'] = 'active';
    if (isset($_GET["request"])) {
        if ($_GET["request"] == "login") {
            $username = $_GET["username"];
            $password = $_GET["password"];
    
            $user = new userModel();
    
            if ($username != null && $password != null) {
                $user -> username = $username;
                $user -> password = $password;
                $login = $user -> login(); //VALIDACION LOGIN
                if ($login == true) {
                    $response['logged'] = true;
                    $response['error'] = "No Error";
                    $_SESSION['user'] = $user->username;
                    $_SESSION['role'] = $user->role; // <-- SESSION variables
                    
                } else {
                    session_unset();
                    session_destroy();
                    $response['logged'] = false;
                    $response['error'] = "Error: Wrong Password";
                }
            } else {
                session_unset();
                session_destroy();
                $response['logged'] = false;
                $response['error']="Ez da username edo password pasatu/No se ha pasado el usuario o la contrasena";
            }
    
        } else if ($_GET["request"] == "logout") {
            session_unset();
            session_destroy();
            $response['logged'] = false;
            $response['error'] = "No Error";
        }
        
    } else {
        session_unset();
        session_destroy();
        $response['logged'] = false;
        $response['error'] = "Solicitud 'Login/Logout' no recibida";
    }

} else {
    session_unset();
    session_destroy();
}

$response['SESSION_Content'] = $_SESSION;
echo json_encode($response);

?>