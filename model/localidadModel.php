<?php
include_once ("connect_data.php");
include_once("localidadClass.php");

class localidadModel extends localidadClass{

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
