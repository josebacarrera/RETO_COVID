<?php

class citaClass
{
    protected $cod;
    protected $tis_paciente;
    protected $cod_paciente;
    protected $fecha;
    protected $hora;
    protected $cod_centro;

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
     * Get the value of tis_paciente
     */ 
    public function getTis_paciente()
    {
        return $this->tis_paciente;
    }

    /**
     * Set the value of tis_paciente
     *
     * @return  self
     */ 
    public function setTis_paciente($tis_paciente)
    {
        $this->tis_paciente = $tis_paciente;

        return $this;
    }

    /**
     * Get the value of cod_paciente
     */ 
    public function getCod_paciente()
    {
        return $this->cod_paciente;
    }

    /**
     * Set the value of cod_paciente
     *
     * @return  self
     */ 
    public function setCod_paciente($cod_paciente)
    {
        $this->cod_paciente = $cod_paciente;

        return $this;
    }

    /**
     * Get the value of fecha
     */ 
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set the value of fecha
     *
     * @return  self
     */ 
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get the value of hora
     */ 
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Set the value of hora
     *
     * @return  self
     */ 
    public function setHora($hora)
    {
        $this->hora = $hora;

        return $this;
    }

    /**
     * Get the value of cod_centro
     */ 
    public function getCod_centro()
    {
        return $this->cod_centro;
    }

    /**
     * Set the value of cod_centro
     *
     * @return  self
     */ 
    public function setCod_centro($cod_centro)
    {
        $this->cod_centro = $cod_centro;

        return $this;
    }
}

?>