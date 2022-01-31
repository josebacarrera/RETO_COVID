<?php

if ($_SERVER['SERVER_NAME']== "hiru.zerbitzaria.net") {include_once ("connect_data_SERV.php");} 
else {include_once ("connect_data_LOCAL.php");}

include_once ("registroVacunacionClass.php");

// ////////////////////////////////////////////////////////////////////////////////////////////
class registroVacunacionModel extends registroVacunacionClass {

    private $link;
    private $objVacuna;

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

        public function selectByTisPaciente() {
            $this->OpenConnect();
            $sql = "SELECT * 
                    FROM registro_vacunacion r
                    INNER JOIN vacuna v ON v.cod_vacuna_v = r.cod_registro_rg
                    WHERE r.tis_registro_rg = ".$this->getTis().";";
            $result = $this->link->query($sql);
            $list=array();
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

                $new = new registroVacunacionModel();
                $new->setCod($row['cod_registro_rg']);
                $new->setTis($row['tis_registro_rg']);
                $new->setCod_vacuna($row['cod_vacuna_rg']);
                $new->setDosis($row['dosis_rg']);
                $new->setFecha_ultima_vacuna($row['fecha_ultima_vacuna_rg']);

                $new->objVacuna = new vacunaModel();
                $new->objVacuna->setCod($row['cod_vacuna_v']);
                $new->objVacuna->setNombre($row['nombre_v']);
                $new->objVacuna->setMax($row['max_v']);
                $new->objVacuna->setIntervalo($row['intervalo_v']);
                $new->objVacuna = $new->objVacuna->ObjVars();

                array_push($list, get_object_vars($new));
            }
            mysqli_free_result($result);
            $this->CloseConnect();
            return $list;
        }

   

}