<?php

if ($_SERVER['SERVER_NAME']== "hiru.zerbitzaria.net") {
    include_once ("connect_data_serv.php");
} else {
    include_once ("connect_data_local.php");
}

include_once 'sanitarioClass.php';

class sanitarioModel extends sanitarioClass{
    
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

    public function selectByDni() {

        $this->OpenConnect();  
        
        $sql = "SELECT * FROM sanitario WHERE dni_s = '".$this->getDni()."';"; 
        
        $result = $this->link->query($sql);
        
        if ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            
            $this->setCod($row['cod_sanitario_s']);
            $this->setNombre($row['nombre_s']);
            $this->setApellido($row['apellido_s']);
            $this->setDni($row['dni_s']);
            $this->setCargo($row['cargo_s']);
            $this->setCod_centro($row['cod_centro_s']);
            $this->setFoto_pefil($row['foto_perfil_s']);

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