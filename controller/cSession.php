<?php
include_once('../model/datosPacienteModel.php');
include_once('../model/sanitarioModel.php');
error_reporting(E_ERROR | E_WARNING | E_PARSE); // <-- Esto solo muestra errores de ejecución

session_start();
$response = array();

if (!empty($_SESSION)) {

    if ($_SESSION['rol'] == 'administrador') {
        $sanitario = new sanitarioModel();
        $sanitario -> setDni($_SESSION['sanitario']['dni']);
        $sanitario -> selectByDni();
        $response['SESSION']['sanitario'] = $sanitario->ObjVars();

    } else if ($_SESSION['rol'] == 'paciente') {
        $paciente = new datosPacienteModel();
        $paciente -> setTis($_SESSION['paciente']['tis']);
        $paciente -> setFecha_nacimiento($_SESSION['paciente']['fecha_nacimiento']);
        $paciente -> loginTIS();
        $response["SESSION"]['paciente'] = $paciente->ObjVars();
    } else {
        $response["SESSION"] = $_SESSION;
    }

    

} else {
    $response["SESSION"] = null;
}

echo json_encode($response);
unset($response);
?>