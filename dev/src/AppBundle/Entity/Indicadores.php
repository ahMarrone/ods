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
    private $valmin;

    /**
     * @var integer
     */
    private $valmax;

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
    private $id;

    /**
     * @var \AppBundle\Entity\Metas
     */
    private $fkidmeta;


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
     * Set valmin
     *
     * @param integer $valmin
     * @return Indicadores
     */
    public function setValmin($valmin)
    {
        $this->valmin = $valmin;

        return $this;
    }

    /**
     * Get valmin
     *
     * @return integer 
     */
    public function getValmin()
    {
        return $this->valmin;
    }

    /**
     * Set valmax
     *
     * @param integer $valmax
     * @return Indicadores
     */
    public function setValmax($valmax)
    {
        $this->valmax = $valmax;

        return $this;
    }

    /**
     * Get valmax
     *
     * @return integer 
     */
    public function getValmax()
    {
        return $this->valmax;
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fkidmeta
     *
     * @param \AppBundle\Entity\Metas $fkidmeta
     * @return Indicadores
     */
    public function setFkidmeta(\AppBundle\Entity\Metas $fkidmeta = null)
    {
        $this->fkidmeta = $fkidmeta;

        return $this;
    }

    /**
     * Get fkidmeta
     *
     * @return \AppBundle\Entity\Metas 
     */
    public function getFkidmeta()
    {
        return $this->fkidmeta;
    }
}
