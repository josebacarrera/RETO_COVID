<?php
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

    public function update() {

        $this->OpenConnect();  
        
        $sql = "UPDATE sanitario SET nombre_s='".$this->getNombre()."', apellido_s='".$this->getApellido()."', dni_s='".$this->getDni()."' WHERE dni_s = '" . $this->getDni() . "'"; 
        
        $result = $this->link->query($sql);
        
        if ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            
            return true;

        }

        mysqli_free_result($result);
        $this->CloseConnect();

    }

    public function ObjVars() {
        return get_object_vars($this);
    }

}