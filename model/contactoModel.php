<?php
//MODELO DE CONTACTO
include_once("connect_data.php");
include_once("contactoClass.php");


class contactoModel extends contactoClass
{

    private $link;

    public function OpenConnect()
    {
        $konDat = new connect_data();
        try {
            $this->link = new mysqli($konDat->host, $konDat->userbbdd, $konDat->passbbdd, $konDat->ddbbname);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        $this->link->set_charset("utf8");
    }

    public function CloseConnect()
    {
        mysqli_close($this->link);
    }

    //CARGAR TODA LA INFORMACIÓN
    public function setFormList()
    {

        $this->OpenConnect();

        $sql = "select * from formulario";

        $list = array();

        $result = $this->link->query($sql);

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

            $newForm = new contactoClass();

            $newForm->id_formulario = $row['id_formulario'];
            $newForm->nombre = $row['nombre'];
            $newForm->correo = $row['correo'];
            $newForm->motivo = $row['motivo'];
            $newForm->otro = $row['otro'];
            $newForm->mensaje = $row['mensaje'];

            array_push($list, $newForm);
        }
        mysqli_free_result($result);
        $this->CloseConnect();
        return $list;
    }
    //INSERTAR DATOS A LA BASE DE DATOS
    public function insert()
    {
        $this->OpenConnect();

        $nombre = $this->nombre;
        $correo = $this->correo;
        $motivo = $this->motivo;
        $otro = $this->otro;
        $mensaje = $this->mensaje;

        $sql = "INSERT INTO formulario(nombre, correo, motivo, otro, mensaje) VALUES ('$nombre', ' $correo', '$motivo', '$otro', '$mensaje')";

        $this->link->query($sql);


        $this->CloseConnect();
    }
}