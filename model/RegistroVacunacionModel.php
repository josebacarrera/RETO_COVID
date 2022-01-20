<?php
/*if ($_SERVER['SERVER_NAME'] == "lau.zerbitzaria.net") {
    include_once ("connect_data_SERV.php");
} else {*/
    include_once ("connect_data_LOCAL.php");
//}

include_once ("registroVacunacionClass.php");

// ////////////////////////////////////////////////////////////////////////////////////////////
class registroVacunacionModel extends registroVacunacionClass
{

    public $link;


    // save director data in the object
    public function OpenConnect()
    {
        $konDat = new connect_data();
        try {
            $this->link = new mysqli($konDat->host, $konDat->userbbdd, $konDat->passbbdd, $konDat->ddbbname);
           
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        $this->link->set_charset("utf8"); // honek behartu egiten du aplikazio eta
                                          // //databasearen artean UTF -8 erabiltzera datuak trukatzeko
    }

    public function CloseConnect()
    {
        mysqli_close($this->link);
    }

    /////////////////////////////////////////////////////////////////////////////////////////////

        // FUNCIONES MOD //

        public function ObjVars() {
            return get_object_vars($this);
        }
   

}