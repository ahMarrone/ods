<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Valoresindicadores
 */
class Valoresindicadores
{
    /**
     * @var \DateTime
     */
    private $anio;

    /**
     * @var boolean
     */
    private $mes;

    /**
     * @var string
     */
    private $valor;

    /**
     * @var boolean
     */
    private $aprobado;

    /**
     * @var \AppBundle\Entity\Etiquetas
     */
    private $idetiqueta;

    /**
     * @var \AppBundle\Entity\Indicadores
     */
    private $idindicador;

    /**
     * @var \AppBundle\Entity\Refgeografica
     */
    private $idrefgeografica;


    /**
     * Set anio
     *
     * @param \DateTime $anio
     * @return Valoresindicadores
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;

        return $this;
    }

    /**
     * Get anio
     *
     * @return \DateTime 
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * Set mes
     *
     * @param boolean $mes
     * @return Valoresindicadores
     */
    public function setMes($mes)
    {
        $this->mes = $mes;

        return $this;
    }

    /**
     * Get mes
     *
     * @return boolean 
     */
    public function getMes()
    {
        return $this->mes;
    }

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
     * @param \AppBundle\Entity\Etiquetas $idetiqueta
     * @return Valoresindicadores
     */
    public function setIdetiqueta(\AppBundle\Entity\Etiquetas $idetiqueta)
    {
        $this->idetiqueta = $idetiqueta;

        return $this;
    }

    /**
     * Get idetiqueta
     *
     * @return \AppBundle\Entity\Etiquetas 
     */
    public function getIdetiqueta()
    {
        return $this->idetiqueta;
    }

    /**
     * Set idindicador
     *
     * @param \AppBundle\Entity\Indicadores $idindicador
     * @return Valoresindicadores
     */
    public function setIdindicador(\AppBundle\Entity\Indicadores $idindicador)
    {
        $this->idindicador = $idindicador;

        return $this;
    }

    /**
     * Get idindicador
     *
     * @return \AppBundle\Entity\Indicadores 
     */
    public function getIdindicador()
    {
        return $this->idindicador;
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
}