<?php


if ($_SERVER['SERVER_NAME']== "hiru.zerbitzaria.net") {
    include_once ("connect_data_SERV.php");
} else {
    include_once ("connect_data_LOCAL.php");
}

include_once("datosPacienteClass.php");

class datosPacienteModel extends datosPacienteClass{

    private $link;

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
        
        $sql = "SELECT *
                FROM datos_paciente d
                INNER JOIN localidad l ON l.cod = d.cod_localidad
                INNER JOIN centro c ON c.cod_localidad = l.cod
                INNER JOIN cita ci ON ci.tis_paciente = d.tis
                INNER JOIN registro_vacunacion r ON r.tis = d.tis
                INNER JOIN vacuna v ON v.cod = r.cod_vacuna
                WHERE d.tis ='" . $this->getTis() . "'  AND d.fecha_nacimiento = '" . $this->getFecha_nacimiento() . "';"; 
        
        $result = $this->link->query($sql);
        
        if ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            
            // $this->setCod($row['cod']);

            // $this->objRol = new rolModel();
            // $this->objRol->setNombre($row['rol']);
            // $this->objRol = $this->objRol->ObjVars();

            // $this->objSanitario = new sanitarioModel();
            // $this->objSanitario->setNombre($row['nombre']);
            // $this->objSanitario->setCargo($row['cargo']);
            // $this->objSanitario = $this->objSanitario->ObjVars();

            // $this->objCentro = new centroModel();
            // $this->objCentro->setNombre($row['centro']);
            // $this->objCentro = $this->objCentro->ObjVars();

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