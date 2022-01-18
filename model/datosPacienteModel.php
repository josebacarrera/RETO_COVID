<?php


if ($_SERVER['SERVER_NAME']== "hiru.zerbitzaria.net") {
    include_once ("connect_data_SERV.php");
} else {
    include_once ("connect_data_LOCAL.php");
}

include_once("datosPacienteClass.php");
include_once("citaModel.php");
include_once("localidadModel.php");
include_once("RegistroVacunacionModel.php");

class datosPacienteModel extends datosPacienteClass{

    private $link;
    private $objLocalidad;
    private $objCita;
    private $objVacunacion;
    private $objVacuna;

    //enlace con la base de datos
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

    public function loginTIS() {

        $this->OpenConnect();  
        
        // $sql = "SELECT *
        //         FROM datos_paciente d
        //         INNER JOIN localidad l ON l.cod = d.cod_localidad
        //         INNER JOIN centro c ON c.cod_localidad = l.cod
        //         INNER JOIN cita ci ON ci.tis_paciente = d.tis
        //         INNER JOIN registro_vacunacion r ON r.tis = d.tis
        //         INNER JOIN vacuna v ON v.cod = r.cod_vacuna
        //         WHERE d.tis ='" . $this->getTis() . "'  AND d.fecha_nacimiento = '" . $this->getFecha_nacimiento() . "';"; 
        
                
        $sql = "SELECT *
                FROM datos_paciente d
                INNER JOIN localidad l ON l.cod = d.cod_localidad
                INNER JOIN centro c ON c.cod_localidad = l.cod
                INNER JOIN cita ci ON ci.tis_paciente = d.tis
                INNER JOIN registro_vacunacion r ON r.tis = d.tis
                INNER JOIN vacuna v ON v.cod = r.cod_vacuna
                WHERE d.tis ='4990916'  AND d.fecha_nacimiento = '2018-03-17';";

        $result = $this->link->query($sql);
        
        if ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            
            $this->setNombre($row['nombre']);
            $this->setApellido($row['apellido']);
            $this->setEmail($row['email']);
            $this->setFoto_perfil($row['foto_perfil']);
            $this->setDireccion($row['direccion']);
            $this->setCod_localidad($row['cod_localidad']);

            $this->objLocalidad = new localidadModel();
            $this->objLocalidad->setCod($row['cod_localidad']);
            $this->objLocalidad->setNombre($row['localidad.nombre']);
            $this->objLocalidad = $this->objLocalidad->ObjVars();

            $this->objCita = new citaModel();
            $this->objCita->setTis_paciente('4990916');
            $this->objCita = $this->objCita->getCitaByTis();

            $this->objVacunacion = new registroVacunacionModel();
            $this->objVacunacion->setTis('4990916');

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