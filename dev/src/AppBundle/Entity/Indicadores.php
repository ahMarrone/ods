<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Indicadores
 */
class Indicadores
{
    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var string
     */
    private $tipo;

    /**
     * @var integer
     */
    private $valMin;

    /**
     * @var integer
     */
    private $valMax;

    /**
     * @var string
     */
    private $ambito;

    /**
     * @var string
     */
    private $visibilidad;

    /**
     * @var integer
     */
    private $idIndicador;

    /**
     * @var \AppBundle\Entity\Metas
     */
    private $fkMeta;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Indicadores
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return Indicadores
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set valMin
     *
     * @param integer $valMin
     * @return Indicadores
     */
    public function setValMin($valMin)
    {
        $this->valMin = $valMin;

        return $this;
    }

    /**
     * Get valMin
     *
     * @return integer 
     */
    public function getValMin()
    {
        return $this->valMin;
    }

    /**
     * Set valMax
     *
     * @param integer $valMax
     * @return Indicadores
     */
    public function setValMax($valMax)
    {
        $this->valMax = $valMax;

        return $this;
    }

    /**
     * Get valMax
     *
     * @return integer 
     */
    public function getValMax()
    {
        return $this->valMax;
    }

    /**
     * Set ambito
     *
     * @param string $ambito
     * @return Indicadores
     */
    public function setAmbito($ambito)
    {
        $this->ambito = $ambito;

        return $this;
    }

    /**
     * Get ambito
     *
     * @return string 
     */
    public function getAmbito()
    {
        return $this->ambito;
    }

    /**
     * Set visibilidad
     *
     * @param string $visibilidad
     * @return Indicadores
     */
    public function setVisibilidad($visibilidad)
    {
        $this->visibilidad = $visibilidad;

        return $this;
    }

    /**
     * Get visibilidad
     *
     * @return string 
     */
    public function getVisibilidad()
    {
        return $this->visibilidad;
    }

    /**
     * Get idIndicador
     *
     * @return integer 
     */
    public function getIdIndicador()
    {
        return $this->idIndicador;
    }

    /**
     * Set fkMeta
     *
     * @param \AppBundle\Entity\Metas $fkMeta
     * @return Indicadores
     */
    public function setFkMeta(\AppBundle\Entity\Metas $fkMeta = null)
    {
        $this->fkMeta = $fkMeta;

        return $this;
    }

    /**
     * Get fkMeta
     *
     * @return \AppBundle\Entity\Metas 
     */
    public function getFkMeta()
    {
        return $this->fkMeta;
    }
}
