<?php
if ($_SERVER['SERVER_NAME']== "hiru.zerbitzaria.net") {
    include_once ("connect_data_SERV.php");
} else {
    include_once ("connect_data_LOCAL.php");
}
include_once("localidadClass.php");

class localidadModel extends localidadClass{

    private $link;
  
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

public function getLocalidad() {
    $this->OpenConnect();

    $sql = "SELECT * FROM localidad WHERE cod = '" . $this->getCod() . "'";

    $result = $this->link->query($sql);
    
    if ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        
        $this->setNombre($row['nombre']);
        return get_object_vars($this);

    }

    mysqli_free_result($result);
    $this->CloseConnect();
}

public function ObjVars() {
    return get_object_vars($this);
}

}  


