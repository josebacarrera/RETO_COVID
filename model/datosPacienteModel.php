<?php


if ($_SERVER['SERVER_NAME']== "hiru.zerbitzaria.net") {
    include_once ("connect_data_SERV.php");
} else {
    include_once ("connect_data_LOCAL.php");
}

include_once("datosPacienteClass.php");

class datosPacienteModel extends datosPacienteClass{

    private $links;
  
public function OpenConnect()
{
    $konDat=new connect_data();
    try
    {
        $this->link=new mysqli($konDat->host,$konDat->userbbdd,$konDat->passbbdd,$konDat->ddbbname);
    }
    catch(Exception $e)
    {
        echo $e->getMessage();
    }
    $this->link->set_charset("utf8"); // honek behartu egiten du aplikazio eta
    //                  //databasearen artean UTF -8 erabiltzera datuak trukatzeko
}

public function CloseConnect()
{
    mysqli_close ($this->link);
}



}
?>