<?php
include_once('../model/datosPacienteModel.php');
include_once('../model/sanitarioModel.php');
error_reporting(E_ERROR | E_WARNING | E_PARSE); // <-- Esto solo muestra errores de ejecución

session_start();
$response = array();

if (!empty($_SESSION)) { // Verificamos si hay una session existente

    if ($_SESSION['rol'] == 'administrador') {
        $sanitario = new sanitarioModel();
        $sanitario -> setDni($_SESSION['sanitario']['dni']);
        $sanitario -> selectByDni();
        $_SESSION['sanitario'] = $sanitario->ObjVars();

    } else if ($_SESSION['rol'] == 'paciente') {
        $paciente = new datosPacienteModel();
        $paciente -> setTis($_SESSION['paciente']['tis']);
        $paciente -> selectByTis();
        $_SESSION['paciente'] = $paciente->ObjVars();
    }

    $response["SESSION"] = $_SESSION;

} else {
    $response["SESSION"] = null;
}

echo json_encode($response);
unset($response);
?>