
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

    // public function loginTIS() {

    //     $this->OpenConnect();
    //     $sql = "CALL spLoginTIS('" . $this->getTis() . "','" . $this->getFecha_nacimiento() . "')";
    //     // $sql = "CALL spLoginTIS('4990916','2018-03-17')";

    //     $result = $this->link->query($sql);
        
    //     if ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            
    //         $this->setNombre($row['nombre_p']);
    //         $this->setApellido($row['apellido_p']);
    //         $this->setEmail($row['email_p']);
    //         $this->setFoto_perfil($row['foto_perfil_p']);
    //         $this->setDireccion($row['direccion_p']);
    //         $this->setCod_localidad($row['cod_localidad_p']);

    //         $this->objLocalidad = new localidadModel();
    //         $this->objLocalidad->setCod($row['cod_localidad_l']);
    //         $this->objLocalidad->setNombre($row['nombre_l']);
    //         $this->objLocalidad = $this->objLocalidad->ObjVars();

    //         $this->objCentro = new centroModel();
    //         $this->objCentro->setCod($row['cod_centro_ce']);
    //         $this->objCentro->setCod_localidad($row['cod_localidad_ce']);
    //         $this->objCentro->setNombre($row['nombre_ce']);
    //         $this->objCentro->setTelefono($row['telefono_ce']);
    //         $this->objCentro->setEmail($row['email_ce']);
    //         $this->objCentro->setHorario_temprano($row['horario_temprano_ce']);
    //         $this->objCentro->setHorario_tarde($row['horario_tarde_ce']);
    //         $this->objCentro->setHorario_noche($row['horario_noche_ce']);
    //         $this->objCentro->setDias($row['dias_ce']);
    //         $this->objCentro = $this->objCentro->ObjVars();

    //         $this->objCita = new citaModel();
    //         $this->objCita->setTis_paciente($row['tis_paciente_ci']);
    //         $this->objCita = $this->objCita->selectByTisPaciente();

    //         $this->objVacunacion = new registroVacunacionModel();
    //         $this->objVacunacion->setTis($row['tis_registro_rg']);
    //         $this->objVacunacion = $this->objVacunacion->selectByTisPaciente();

    //         return true;

    //     }

    //     mysqli_free_result($result);
    //     $this->CloseConnect();
    // }

    public function insert() {
        $this->OpenConnect();
        $sql="SELECT * FROM datos_paciente WHERE nombre_p='".$this->getNombre()."' AND apellido_p='".$this->getApellido()."' AND fecha_nacimiento_p='".$this->getFecha_nacimiento()."'";
        if ($this->link->query($sql)) {
            $sql ="UPDATE datos_paciente SET status_p = 1 WHERE tis_datos_p = '" . $this->getTis() . "';";
        }else{
            $sql = "INSERT INTO datos_paciente (nombre_p, apellido_p, fecha_nacimiento_p, email_p, direccion_p, cod_localidad_p) VALUES ('".$this->getNombre()."','".$this->getApellido()."','".$this->getFecha_nacimiento()."','".$this->getEmail()."','".$this->getDireccion()."',".$this->getCod_localidad().")";

        }

        $this->link->query($sql);
        $this->CloseConnect();
    }

    public function getAllTis() {
        $this->OpenConnect();
        $sql="SELECT tis_datos_p, nombre_p FROM datos_paciente WHERE status_p =1";
        $result=$this->link->query($sql);
        $list=array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($list, $row['tis_datos_p'] . ' - '.  $row['nombre_p']);
        }
        return $list;
        mysqli_free_result($result);
        $this->CloseConnect();
    }

    public function deletePacienteByTis(){
        $this->OpenConnect();
        $sql ="UPDATE datos_paciente SET status_p = 0 WHERE tis_datos_p = '" . $this->getTis() . "';";
        $deleted=false;
        if ($this->link->query($sql)) {
            $deleted = true;
        }
        $this->CloseConnect();
        return $deleted;  
    }

    // COMPROBADO

    public function loginTIS() {
        $this->OpenConnect();
        $sql = "SELECT * 
                FROM datos_paciente 
                WHERE tis_datos_p = '" . $this->getTis() . "' AND fecha_nacimiento_p = '" . $this->getFecha_nacimiento() . "' AND status_p = 1;";
        $logged = false;
        if ( $this->link->query($sql)) {
            $logged = true;
        }
        $this->CloseConnect();
        return $logged;  
    }

    public function selectByTis() {
        $this->OpenConnect();
        $sql = "SELECT * 
                FROM datos_paciente d
                INNER JOIN localidad l ON l.cod_localidad_l = d.cod_localidad_p
                INNER JOIN centro c ON c.cod_localidad_ce = l.cod_localidad_l
                WHERE tis_datos_p='".$this->getTis()."'";
        $result = $this->link->query($sql);
        if ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

            $this->setTis($row['tis_datos_p']);
            $this->setNombre($row['nombre_p']);
            $this->setApellido($row['apellido_p']);
            $this->setFecha_nacimiento($row['fecha_nacimiento_p']);
            $this->setEmail($row['email_p']);
            $this->setFoto_perfil($row['foto_perfil_p']);
            $this->setDireccion($row['direccion_p']);
            $this->setCod_localidad($row['cod_localidad_p']);
            $this->setTelefono($row['telefono_p']);

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
            $this->objCita->setTis_paciente($row['tis_datos_p']);
            $this->objCita = $this->objCita->selectByTisPaciente();

            $this->objVacunacion = new registroVacunacionModel();
            $this->objVacunacion->setTis($row['tis_datos_p']);
            $this->objVacunacion = $this->objVacunacion->selectByTisPaciente();
        }
        mysqli_free_result($result);
        $this->CloseConnect();
    }

    public function ObjVars() {
        return get_object_vars($this);
    }

}
?>