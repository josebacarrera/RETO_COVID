//CONTROLLADOR DE CONTACTO
<?php
require_once("../model/contactoModel.php");

$formArray = json_decode($_POST['datos']);
$nombre = $formArray->Nombre;
$correo = $formArray->Correo;
$motivo = $formArray->MotivoS;
$otro = $formArray->MasMotivo;
$mensaje = $formArray->Mensaje;

$formulario = new contactoModel();

if (isset($nombre)) {
    $formulario->setNombre($nombre);
}
if (isset($correo)) {
    $formulario->setCorreo($correo);
}
if (isset($motivo)) {
    $formulario->setMotivo($motivo);
}
if (isset($otro)) {
    $formulario->setOtro($otro);
}
if (isset($mensaje)) {
    $formulario->setMensaje($mensaje);
}

$response['error'] = $formulario->insert();
echo json_encode($response);
unset($response);
?>