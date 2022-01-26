<?php

if ($_SERVER['SERVER_NAME']== "hiru.zerbitzaria.net") {include_once ("connect_data_SERV.php");} 
else {include_once ("connect_data_LOCAL.php");}

include_once("datosPacienteClass.php");
include_once("citaModel.php");
include_once("localidadModel.php");
include_once("RegistroVacunacionModel.php");
include_once("centroModel.php");
include_once("vacunaModel.php");

class datosPacienteModel extends datosPacienteClass{

    private $link;
    private $objLocalidad;
    private $objCita;
    private $objVacunacion;
    private $objVacuna;
    private $objCentro;

    public function OpenConnect(){
        $kondat=new connect_data();
        try{
            $this->link=new mysqli($kondat->host,$kondat->userbbdd,$kondat->passbbdd,$kondat->ddbbname);
            // creamos el objeto link en la clase mysqli con la informacion de conexion
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
        $this->link->set_charset("utf8");
        // forzamos el uso de utf8 para el intercambio de datos entre la aplicacion y la base de datos

    }
    public function CloseConnect() {
        mysqli_close ($this->link);
    }

    public function     loginTIS() {

        $this->OpenConnect();
        $sql = "CALL spLoginTIS('" . $this->getTis() . "','" . $this->getFecha_nacimiento() . "')";
        // $sql = "CALL spLoginTIS('4990916','2018-03-17')";

        $result = $this->link->query($sql);
        
        if ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            
            $this->setNombre($row['nombre_p']);
            $this->setApellido($row['apellido_p']);
            $this->setEmail($row['email_p']);
            $this->setFoto_perfil($row['foto_perfil_p']);
            $this->setDireccion($row['direccion_p']);
            $this->setCod_localidad($row['cod_localidad_p']);

            $this->objLocalidad = new localidadModel();
            $this->objLocalidad->setCod($row['cod_localidad_l']);
            $this->objLocalidad->setNombre($row['nombre_l']);
            $this->objLocalidad = $this->objLocalidad->ObjVars();

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

            $this->objCita = new citaModel();
            $this->objCita->setCod($row['cod_cita_ci']);
            $this->objCita->setTis_paciente($row['tis_paciente_ci']);
            $this->objCita->setCod_sanitario($row['cod_sanitario_ci']);
            $this->objCita->setFecha($row['fecha_ci']);
            $this->objCita->setHora($row['hora_ci']);
            $this->objCita->setCod_centro($row['cod_centro_ci']);
            $this->objCita = $this->objCita->ObjVars();

            $this->objVacunacion = new registroVacunacionModel();
            $this->objVacunacion->setCod($row['cod_registro_rg']);
            $this->objVacunacion->setTis($row['tis_registro_rg']);
            $this->objVacunacion->setCod_vacuna($row['cod_vacuna_rg']);
            $this->objVacunacion->setDosis($row['dosis_rg']);
            $this->objVacunacion->setFecha_ultima_vacuna($row['fecha_ultima_vacuna_rg']);
            $this->objVacunacion = $this->objVacunacion->ObjVars();

            $this->objVacuna = new vacunaModel();
            $this->objVacuna->setCod($row['cod_vacuna_v']);
            $this->objVacuna->setNombre($row['nombre_v']);
            $this->objVacuna->setMax($row['max_v']);
            $this->objVacuna->setIntervalo($row['intervalo_v']);
            $this->objVacuna = $this->objVacuna->ObjVars();

            return true;

        }

        mysqli_free_result($result);
        $this->CloseConnect();
    }

    public function insert() {
        $this->OpenConnect();
        $sql = "INSERT INTO datos_paciente (tis_datos_p, nombre_p, apellido_p, fecha_nacimiento_p, email_p, foto_perfil_p, direccion_p, cod_localidad_p) VALUES ('".$this->getTis()."','".$this->getNombre()."','".$this->getApellido()."','".$this->getFecha_nacimiento()."','".$this->getEmail()."','".$this->getDireccion()."','".$this->getCod_localidad()."')";
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
?>