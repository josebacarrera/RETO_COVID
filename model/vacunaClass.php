<?php

class vacunaClass{
    protected $cod;
    protected $nombre;
    protected $max;
    protected $intervalo;
    

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
     * Get the value of max
     */ 
    public function getMax()
    {
        return $this->max;
    }

    /**
     * Set the value of max
     *
     * @return  self
     */ 
    public function setMax($max)
    {
        $this->max = $max;

        return $this;
    }

    /**
     * Get the value of intervalo
     */ 
    public function getIntervalo()
    {
        return $this->intervalo;
    }

    /**
     * Set the value of intervalo
     *
     * @return  self
     */ 
    public function setIntervalo($intervalo)
    {
        $this->intervalo = $intervalo;

        return $this;
    }
}