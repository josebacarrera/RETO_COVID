<?php

include_once 'userClass.php';
include_once 'rolModel.php';
include_once 'sanitarioModel.php';

if ($_SERVER['SERVER_NAME']== "hiru.zerbitzaria.net") {
    include_once ("connect_data_serv.php");
} else {
    include_once ("connect_data_local.php");
}

class userModel extends userClass{
    
    private $link;  // datu basera lotura - enlace a la bbdd 
    private $objRol;
    private $objSanitario;

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

    

    // COMPROBADO

    public function loginDNI() {
        $this->OpenConnect();  
        $sql = "SELECT *
                FROM user u
                INNER JOIN rol r ON r.cod_r = u.cod_rol_u
                WHERE dni_sanitario_u = '".$this->getDni_sanitario()."' AND password_u = '".$this->getPassword()."'"; 
        $result = $this->link->query($sql);
        $logged = false;
        if ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $this->objRol = new rolModel();
            $this->objRol->setNombre($row['nombre_r']);
            $this->objRol = $this->objRol->ObjVars();
            $logged = true;
        } 
        mysqli_free_result($result);
        $this->CloseConnect();
        return $logged;
    }

    public function ObjVars() {
        return get_object_vars($this);
    }

}