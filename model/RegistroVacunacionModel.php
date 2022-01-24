<?php

if ($_SERVER['SERVER_NAME']== "hiru.zerbitzaria.net") {include_once ("connect_data_SERV.php");} 
else {include_once ("connect_data_LOCAL.php");}

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

    
    // FUNCIONES MOD //

    public function ObjVars() {
        return get_object_vars($this);
    }

    /////////////////////////////////////////////////////////////////////////////////////////////

        // FUNCIONES MOD //

        public function getRegistroVacunacion() {

            $this->OpenConnect();

            $sql = "SELECT * FROM registro_vacunacion WHERE tis_registro_rg='".$this->getTis()."'";
            $result = $this->link->query($sql);
            
            if ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $this->setCod($row['cod_registro_rg']);
                $this->setCod_vacuna($row['cod_vacuna_rg']);
                $this->setDosis($row['dosis_rg']);
                $this->setFecha_ultima_vacuna($row['fecha_ultima_vacuna_rg']);
                return true;
            }

            mysqli_free_result($result);
            $this->CloseConnect();

        }

   

}