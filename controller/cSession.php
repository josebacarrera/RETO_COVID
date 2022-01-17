<?php
session_start();
$response = array();

if (!empty($_SESSION)) {
    $response["SESSION"] = $_SESSION;
} else {
    $response["SESSION"] = null;
}

echo json_encode($response);
?>