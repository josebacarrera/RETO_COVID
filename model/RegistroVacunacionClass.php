<?php

class registroVacunacionClass
{
    protected $cod;
    protected $tis;
    protected $cod_vacuna;
    protected $dosis;
    protected $fecha_ultima_vacuna;

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
     * Get the value of tis
     */ 
    public function getTis()
    {
        return $this->tis;
    }

    /**
     * Set the value of tis
     *
     * @return  self
     */ 
    public function setTis($tis)
    {
        $this->tis = $tis;

        return $this;
    }

    /**
     * Get the value of cod_vacuna
     */ 
    public function getCod_vacuna()
    {
        return $this->cod_vacuna;
    }

    /**
     * Set the value of cod_vacuna
     *
     * @return  self
     */ 
    public function setCod_vacuna($cod_vacuna)
    {
        $this->cod_vacuna = $cod_vacuna;

        return $this;
    }

    /**
     * Get the value of dosis
     */ 
    public function getDosis()
    {
        return $this->dosis;
    }

    /**
     * Set the value of dosis
     *
     * @return  self
     */ 
    public function setDosis($dosis)
    {
        $this->dosis = $dosis;

        return $this;
    }

    /**
     * Get the value of fecha_ultima_vacuna
     */ 
    public function getFecha_ultima_vacuna()
    {
        return $this->fecha_ultima_vacuna;
    }

    /**
     * Set the value of fecha_ultima_vacuna
     *
     * @return  self
     */ 
    public function setFecha_ultima_vacuna($fecha_ultima_vacuna)
    {
        $this->fecha_ultima_vacuna = $fecha_ultima_vacuna;

        return $this;
    }
}