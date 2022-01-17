<?php

include_once 'userClass.php';
include_once 'rolModel.php';
include_once 'sanitarioModel.php';
include_once 'centroModel.php';

if ($_SERVER['SERVER_NAME']== "hiru.zerbitzaria.net") {
    include_once ("connect_data_serv.php");
} else {
    include_once ("connect_data_local.php");
}

class userModel extends userClass{
    
    private $link;  // datu basera lotura - enlace a la bbdd 
    private $objRol;
    private $objSanitario; 
    private $objCentro;

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

    public function loginDNI() {

        $this->OpenConnect();  
        
        $sql = "CALL spLogin('" . $this->getDni_sanitario() . "','" . $this->getPassword() . "')"; 
        
        $result = $this->link->query($sql);
        
        if ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            
            $this->setCod($row['cod']);

            $this->objRol = new rolModel();
            $this->objRol->setNombre($row['rol']);
            $this->objRol = $this->objRol->ObjVars();

            $this->objSanitario = new sanitarioModel();
            $this->objSanitario->setNombre($row['nombre']);
            $this->objSanitario->setCargo($row['cargo']);
            $this->objSanitario = $this->objSanitario->ObjVars();

            $this->objCentro = new centroModel();
            $this->objCentro->setNombre($row['centro']);
            $this->objCentro = $this->objCentro->ObjVars();

            return true;

        }

        mysqli_free_result($result);
        $this->CloseConnect();
    }

    public function ObjVars() {
        return get_object_vars($this);
    }

}