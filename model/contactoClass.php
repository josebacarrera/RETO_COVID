<?php
class contactoClass{
protected $id_formulario;
protected $nombre;
protected $correo;
protected $motivo;
protected $otro;
protected $mensaje;

/**
 * Get the value of id_formulario
 */ 
public function getId_formulario()
{
return $this->id_formulario;
}

/**
 * Set the value of id_formulario
 *
 * @return  self
 */ 
public function setId_formulario($id_formulario)
{
$this->id_formulario = $id_formulario;

return $this;
}

/**
 * Get the value of nombre
 */ 
public function getNombre()
{
return $this->nombre;
}

/**
 * Set the value of nombre
 *
 * @return  self
 */ 
public function setNombre($nombre)
{
$this->nombre = $nombre;

return $this;
}

/**
 * Get the value of correo
 */ 
public function getCorreo()
{
return $this->correo;
}

/**
 * Set the value of correo
 *
 * @return  self
 */ 
public function setCorreo($correo)
{
$this->correo = $correo;

return $this;
}

/**
 * Get the value of motivo
 */ 
public function getMotivo()
{
return $this->motivo;
}

/**
 * Set the value of motivo
 *
 * @return  self
 */ 
public function setMotivo($motivo)
{
$this->motivo = $motivo;

return $this;
}

/**
 * Get the value of otro
 */ 
public function getOtro()
{
return $this->otro;
}

/**
 * Set the value of otro
 *
 * @return  self
 */ 
public function setOtro($otro)
{
$this->otro = $otro;

return $this;
}

/**
 * Get the value of mensaje
 */ 
public function getMensaje()
{
return $this->mensaje;
}

/**
 * Set the value of mensaje
 *
 * @return  self
 */ 
public function setMensaje($mensaje)
{
$this->mensaje = $mensaje;

return $this;
}
}
?>