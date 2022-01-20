<?php
class centroClass 
{
    protected $cod;
    protected $cod_localidad;
    protected $nombre;
    protected $telefono;
    protected $email;
    protected $horario_temprano;
    protected $horario_tarde;
    protected $horario_noche;
    protected $dias;

    /**
     * Get the value of cod
     */ 
    public function getCod()
    {
        return $this->cod;
    }

    /**
     * Set the value of cod
     *
     * @return  self
     */ 
    public function setCod($cod)
    {
        $this->cod = $cod;

        return $this;
    }

    /**
     * Get the value of cod_localidad
     */ 
    public function getCod_localidad()
    {
        return $this->cod_localidad;
    }

    /**
     * Set the value of cod_localidad
     *
     * @return  self
     */ 
    public function setCod_localidad($cod_localidad)
    {
        $this->cod_localidad = $cod_localidad;

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
     * Get the value of telefono
     */ 
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set the value of telefono
     *
     * @return  self
     */ 
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of horario_temprano
     */ 
    public function getHorario_temprano()
    {
        return $this->horario_temprano;
    }

    /**
     * Set the value of horario_temprano
     *
     * @return  self
     */ 
    public function setHorario_temprano($horario_temprano)
    {
        $this->horario_temprano = $horario_temprano;

        return $this;
    }

    /**
     * Get the value of horario_tarde
     */ 
    public function getHorario_tarde()
    {
        return $this->horario_tarde;
    }

    /**
     * Set the value of horario_tarde
     *
     * @return  self
     */ 
    public function setHorario_tarde($horario_tarde)
    {
        $this->horario_tarde = $horario_tarde;

        return $this;
    }

    /**
     * Get the value of horario_noche
     */ 
    public function getHorario_noche()
    {
        return $this->horario_noche;
    }

    /**
     * Set the value of horario_noche
     *
     * @return  self
     */ 
    public function setHorario_noche($horario_noche)
    {
        $this->horario_noche = $horario_noche;

        return $this;
    }

    /**
     * Get the value of dias
     */ 
    public function getDias()
    {
        return $this->dias;
    }

    /**
     * Set the value of dias
     *
     * @return  self
     */ 
    public function setDias($dias)
    {
        $this->dias = $dias;

        return $this;
    }
}
