<?php
class userClass
{
    protected $cod;
    protected $cod_rol;
    protected $password;
    protected $dni_sanitario;

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
     * Get the value of cod_rol
     */ 
    public function getCod_rol()
    {
        return $this->cod_rol;
    }

    /**
     * Set the value of cod_rol
     *
     * @return  self
     */ 
    public function setCod_rol($cod_rol)
    {
        $this->cod_rol = $cod_rol;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of dni_sanitario
     */ 
    public function getDni_sanitario()
    {
        return $this->dni_sanitario;
    }

    /**
     * Set the value of dni_sanitario
     *
     * @return  self
     */ 
    public function setDni_sanitario($dni_sanitario)
    {
        $this->dni_sanitario = $dni_sanitario;

        return $this;
    }
}