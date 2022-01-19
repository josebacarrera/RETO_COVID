<?php


if ($_SERVER['SERVER_NAME']== "hiru.zerbitzaria.net") {
    include_once ("connect_data_SERV.php");
} else {
    include_once ("connect_data_LOCAL.php");
}

include_once("datosPacienteClass.php");

class datosPacienteModel extends datosPacienteClass{

    private $link;

    //enlace con la base de datos
    public function OpenConnect(){
        $kondat=new connect_data();
        try{
            $this->link=new mysqli($kondat->host,$kondat->userbbdd,$kondat->passbbdd,$kondat->ddbbname);
            // creamos el objeto link en la clase mysqli con la informacion de conexion
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
        $this->link->set_charset("utf8");
        // forzamos el uso de utf8 para el intercambio de datos entre la aplicacion y la base de datos

    }
    public function CloseConnect() {
        mysqli_close ($this->link);
    }
}
?>