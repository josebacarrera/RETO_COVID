<?php

if ($_SERVER['SERVER_NAME']== "hiru.zerbitzaria.net") {
    include_once ("connect_data_serv.php");
} else {
    include_once ("connect_data_local.php");
}

include_once("citaClass.php");

class citaModel extends citaClass {

    private $link;  // datu basera lotura - enlace a la bbdd  

    public function OpenConnect() {
        $konDat=new connect_data();
        try
        {
            $this->link=new mysqli($konDat->host,$konDat->userbbdd,$konDat->passbbdd,$konDat->ddbbname);
            // mysqli klaseko link objetua sortzen da dagokion konexio datuekin
            // se crea un nuevo objeto llamado link de la clase mysqli con los datos de conexión. 
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        $this->link->set_charset("utf8"); // honek behartu egiten du aplikazio eta 
                        //databasearen artean UTF -8 erabiltzera datuak trukatzeko
    }                   
        
    public function CloseConnect() {
        mysqli_close ($this->link);
    }

    // FUNCIONES MOD //

    public function getCitaByTis() {
        $this->OpenConnect();
        $sql = "SELECT * FROM cita WHERE tis_paciente = '" . $this->getTis_paciente() . "'";
        $result = $this->link->query($sql);
        $list=array();
        if ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $newCita = new citaModel();
            $newCita->setCod($row['cod']);
            $newCita->setTis_paciente($row['tis_paciente']);
            $newCita->setCod_sanitario($row['cod_sanitario']);
            $newCita->setFecha($row['fecha']);
            $newCita->setHora($row['hora']);
            $newCita->setCod_centro($row['cod_centro']);
            array_push($list, get_object_vars($newCita));
        }
        return $list;  
        mysqli_free_result($result);
        $this->CloseConnect();
    }

    public function ObjVars() {
        return get_object_vars($this);
    }

}

?>