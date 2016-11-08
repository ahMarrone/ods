<?php
// src/AppBundle/Entity/Usuarios.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;


class Usuarios extends BaseUser
{

    protected $id;


    /**
     * @var string
     */
    private $apellido;


     /**
     * @var string
     */
    private $nombre;


     /**
     * @var string
     */
    private $domicilio;

    /**
     * @var string
     */
    private $localidad;

    /**
     * @var string
     */
    private $provincia;

    /**
     * @var string
     */
    private $telefono;

    /**
     * @var string
     */
    private $dependencia;


    /**
     * @var string
     */
    private $observaciones;



    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Set apellido
     *
     * @param string $apellido
     * @return Usuarios
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->apellido;
    }


        /**
     * Set nombre
     *
     * @param string $nombre
     * @return Usuarios
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }


            /**
     * Set domicilio
     *
     * @param string $domicilio
     * @return Usuarios
     */
    public function setDomicilio($domicilio)
    {
        $this->domicilio = $domicilio;

        return $this;
    }

    /**
     * Get domicilio
     *
     * @return string 
     */
    public function getDomicilio()
    {
        return $this->domicilio;
    }


                /**
     * Set localidad
     *
     * @param string $localidad
     * @return Usuarios
     */
    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * Get localidad
     *
     * @return string 
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }



                    /**
     * Set provincia
     *
     * @param string $provincia
     * @return Usuarios
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return string 
     */
    public function getProvincia()
    {
        return $this->provincia;
    }



                    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Usuarios
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }


                        /**
     * Set dependencia
     *
     * @param string $dependencia
     * @return Usuarios
     */
    public function setDependencia($dependencia)
    {
        $this->dependencia = $dependencia;

        return $this;
    }

    /**
     * Get dependencia
     *
     * @return string 
     */
    public function getDependencia()
    {
        return $this->dependencia;
    }


                            /**
     * Set observaciones
     *
     * @param string $observaciones
     * @return Usuarios
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string 
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

}

