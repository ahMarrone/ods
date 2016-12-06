<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Valoresindicadores
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ValoresindicadoresRepository")
 */
class Valoresindicadores
{

    /**
     * @var string
     */
    private $valor;

    /**
     * @var boolean
     */
    private $aprobado;

    /**
     * @var string
     */
    private $idetiqueta;


    /**
     * @var \AppBundle\Entity\Refgeografica
     */
    private $idrefgeografica;



    /**
     * @var string
     */
    private $fechamodificacion;

    /**
     * @var \AppBundle\Entity\Usuarios
     */
    private $idusuario;

        /**
     * @var \AppBundle\Entity\Valoresindicadoresconfigfecha
     */
    private $idvaloresindicadoresconfigfecha;



    /**
     * Set valor
     *
     * @param string $valor
     * @return Valoresindicadores
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return string 
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set aprobado
     *
     * @param boolean $aprobado
     * @return Valoresindicadores
     */
    public function setAprobado($aprobado)
    {
        $this->aprobado = $aprobado;

        return $this;
    }

    /**
     * Get aprobado
     *
     * @return boolean 
     */
    public function getAprobado()
    {
        return $this->aprobado;
    }

    /**
     * Set idetiqueta
     *
     * @param string $idetiqueta
     * @return Valoresindicadores
     */
    public function setIdetiqueta($idetiqueta)
    {
        $this->idetiqueta = $idetiqueta;

        return $this;
    }

    /**
     * Get idetiqueta
     *
     * @return string
     */
    public function getIdetiqueta()
    {
        return $this->idetiqueta;
    }


    /**
     * Set idrefgeografica
     *
     * @param \AppBundle\Entity\Refgeografica $idrefgeografica
     * @return Valoresindicadores
     */
    public function setIdrefgeografica(\AppBundle\Entity\Refgeografica $idrefgeografica)
    {
        $this->idrefgeografica = $idrefgeografica;

        return $this;
    }

    /**
     * Get idrefgeografica
     *
     * @return \AppBundle\Entity\Refgeografica 
     */
    public function getIdrefgeografica()
    {
        return $this->idrefgeografica;
    }


    /**
     * Set fechamodificacion
     *
     * @param string $fechamodificacion
     * @return Valoresindicadores
     */
    public function setFechamodificacion($fechamodificacion)
    {
        $this->fechamodificacion = $fechamodificacion;

        return $this;
    }

    /**
     * Get fechamodificacion
     *
     * @return string 
     */
    public function getFechamodificacion()
    {
        return $this->fechamodificacion;
    }

    /**
     * Set idusuario
     *
     * @param \AppBundle\Entity\Usuarios $idusuario
     * @return Valoresindicadores
     */
    public function setIdusuario(\AppBundle\Entity\Usuarios $idusuario = null)
    {
        $this->idusuario = $idusuario;

        return $this;
    }

    /**
     * Get idusuario
     *
     * @return \AppBundle\Entity\Usuarios 
     */
    public function getIdusuario()
    {
        return $this->idusuario;
    }


    /**
     * Set idvaloresindicadoresconfigfecha
     *
     * @param \AppBundle\Entity\Valoresindicadoresconfigfecha $idvaloresindicadoresconfigfecha
     * @return Valoresindicadores
     */
    public function setIdvaloresindicadoresconfigfecha(\AppBundle\Entity\Valoresindicadoresconfigfecha $idvaloresindicadoresconfigfecha)
    {
        $this->idvaloresindicadoresconfigfecha = $idvaloresindicadoresconfigfecha;

        return $this;
    }

    /**
     * Get idvaloresindicadoresconfigfecha
     *
     * @return \AppBundle\Entity\Valoresindicadoresconfigfecha 
     */
    public function getIdvaloresindicadoresconfigfecha()
    {
        return $this->idvaloresindicadoresconfigfecha;
    }
}
