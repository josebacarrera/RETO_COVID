<?php

if ($_SERVER['SERVER_NAME']== "hiru.zerbitzaria.net") {
    include_once ("connect_data_serv.php");
} else {
    include_once ("connect_data_local.php");
}

include_once 'sanitarioClass.php';

class sanitarioModel extends sanitarioClass{
    
    private $link;
    private $objCentro;
    private $objLocalidad;
    private $objcita; 

    public function OpenConnect() {
        $konDat=new connect_data();
        try {$this->link=new mysqli($konDat->host,$konDat->userbbdd,$konDat->passbbdd,$konDat->ddbbname);} 
        catch(Exception $e) {echo $e->getMessage();}
        $this->link->set_charset("utf8");
    }                   
        
    public function CloseConnect() {
        mysqli_close ($this->link);
    }

    // FUNCIONES MOD //

    public function selectByDni() {

        $this->OpenConnect();  
        
        $sql = "SELECT *
                FROM sanitario s
                INNER JOIN centro ce ON ce.cod_centro_ce = s.cod_centro_s
                INNER JOIN localidad l ON l.cod_localidad_l = ce.cod_localidad_ce
                WHERE dni_s = '".$this->getDni()."';"; 
        
        $result = $this->link->query($sql);
        
        if ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            
            $this->setCod($row['cod_sanitario_s']);
            $this->setNombre($row['nombre_s']);
            $this->setApellido($row['apellido_s']);
            $this->setDni($row['dni_s']);
            $this->setCargo($row['cargo_s']);
            $this->setCod_centro($row['cod_centro_s']);
            $this->setFoto_pefil($row['foto_perfil_s']);

            $this->objCita = new citaModel();
            $this->objCita->setCod_sanitario($row['cod_sanitario_s']);
            $this->objCita = $this->objCita->selectByDniSanitario();

            $this->objCentro = new centroModel();
            $this->objCentro->setCod($row['cod_centro_ce']);
            $this->objCentro->setCod_localidad($row['cod_localidad_ce']);
            $this->objCentro->setNombre($row['nombre_ce']);
            $this->objCentro->setTelefono($row['telefono_ce']);
            $this->objCentro->setEmail($row['email_ce']);
            $this->objCentro->setHorario_temprano($row['horario_temprano_ce']);
            $this->objCentro->setHorario_tarde($row['horario_tarde_ce']);
            $this->objCentro->setHorario_noche($row['horario_noche_ce']);
            $this->objCentro->setDias($row['dias_ce']);
            $this->objCentro = $this->objCentro->ObjVars();
            
            $this->objLocalidad = new localidadModel();
            $this->objLocalidad->setCod($row['cod_localidad_l']);
            $this->objLocalidad->setNombre($row['nombre_l']);
            $this->objLocalidad = $this->objLocalidad->ObjVars();

            return true;
        }

    }

    public function update() {
        $this->OpenConnect();  
        if($this->getFoto_pefil()!=NULL){
            $sql = "UPDATE sanitario SET nombre_s='".$this->getNombre()."',foto_perfil_s='".$this->getFoto_pefil()."', apellido_s='".$this->getApellido()."', dni_s='".$this->getDni()."' WHERE dni_s = '" . $this->getDni() . "'"; 
        }else{
            $sql = "UPDATE sanitario SET nombre_s='".$this->getNombre()."', apellido_s='".$this->getApellido()."', dni_s='".$this->getDni()."' WHERE dni_s = '" . $this->getDni() . "'"; 
        }
        
        if ($this->link->query($sql))  // true if success
        //$this->link->affected_rows;  number of inserted rows
        {
            return "Record updated successfully.Num de updates: ".$this->link->affected_rows;
        } else {
            return "Error updating ". $sql ."   ". $this->link->error;
        }
        $this->CloseConnect();

    }

    public function ObjVars() {
        return get_object_vars($this);
    }

}