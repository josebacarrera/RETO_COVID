<?php
include_once ("../model/RegistroVacunacionModel.php");

$proveedor = new RegistroVacunacionModel();

$response = array();

$response['']=$registroVacunacion->setList();

$response['error']="no error";

echo json_encode($response);

unset($proveedor);
unset($response);