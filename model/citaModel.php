<?php

if ($_SERVER['SERVER_NAME']== "hiru.zerbitzaria.net") {include_once ("connect_data_SERV.php");} 
else {include_once ("connect_data_LOCAL.php");}

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

    public function selectAllFechasHorasFromCentro() {
        $this->OpenConnect();
        $sql = "SELECT fecha_ci, hora_ci FROM cita WHERE cod_centro_ci  = '" . $this->getCod_centro() . "'";
        $result = $this->link->query($sql);
        $list=array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $newCita = new citaModel();
            $newCita->setCod($row['cod_cita_ci']);
            $newCita->setTis_paciente($row['tis_paciente_ci']);
            $newCita->setCod_sanitario($row['cod_sanitario_ci']);
            $newCita->setFecha($row['fecha_ci']);
            $newCita->setHora($row['hora_ci']);
            $newCita->setCod_centro($row['cod_centro_ci']);
            array_push($list, get_object_vars($newCita));
        }
        return $list;
        mysqli_free_result($result);
        $this->CloseConnect();
    }

    public function selectHoraByFechaCentro() {
        $this->OpenConnect();
        $sql = "SELECT hora_ci FROM cita WHERE fecha_ci  = '" . $this->getFecha() . "' AND cod_centro_ci = ". $this->getCod_centro();
        $result = $this->link->query($sql);
        $list=array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($list, $row['hora_ci']);
        }
        return $list;
        mysqli_free_result($result);
        $this->CloseConnect();
    }

    public function selectAllByTis() {
        $this->OpenConnect();
        $sql = "SELECT * FROM cita WHERE tis_paciente_ci  = '" . $this->getTis_paciente() . "'";
        $result = $this->link->query($sql);
        $list=array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $newCita = new citaModel();
            $newCita->setCod($row['cod_cita_ci']);
            $newCita->setTis_paciente($row['tis_paciente_ci']);
            $newCita->setCod_sanitario($row['cod_sanitario_ci']);
            $newCita->setFecha($row['fecha_ci']);
            $newCita->setHora($row['hora_ci']);
            $newCita->setCod_centro($row['cod_centro_ci']);
            array_push($list, get_object_vars($newCita));
        }
        return $list;
        mysqli_free_result($result);
        $this->CloseConnect();
    }

    public function insertCita() {
        $this->OpenConnect();
        $sql='INSERT INTO cita (tis_paciente_ci,cod_sanitario_ci, fecha_ci, hora_ci,cod_centro_ci) VALUES ("'.$this->getTis_paciente().'","'.$this->getCod_sanitario().'","'.$this->getFecha().'","'.$this->getHora().'","'.$this->getCod_centro().'")';
        // var_dump($sql);
        if ($this->link->query($sql)) {
            return true;
        }
        $this->CloseConnect();
    }

    public function ObjVars() {
        return get_object_vars($this);
    }

}

?>