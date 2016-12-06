<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Desgloces
 */
class Desgloces
{
    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var integer
     */
    private $id;


    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $idvaloresindicadoresconfigfecha;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $idindicador;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Desgloces
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }


    public function __toString(){
        return $this->getDescripcion();
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idvaloresindicadoresconfigfecha = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idindicador = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add idvaloresindicadoresconfigfecha
     *
     * @param \AppBundle\Entity\Valoresindicadoresconfigfecha $idvaloresindicadoresconfigfecha
     * @return Desgloces
     */
    public function addIdvaloresindicadoresconfigfecha(\AppBundle\Entity\Valoresindicadoresconfigfecha $idvaloresindicadoresconfigfecha)
    {
        $this->idvaloresindicadoresconfigfecha[] = $idvaloresindicadoresconfigfecha;

        return $this;
    }

    /**
     * Remove idvaloresindicadoresconfigfecha
     *
     * @param \AppBundle\Entity\Valoresindicadoresconfigfecha $idvaloresindicadoresconfigfecha
     */
    public function removeIdvaloresindicadoresconfigfecha(\AppBundle\Entity\Valoresindicadoresconfigfecha $idvaloresindicadoresconfigfecha)
    {
        $this->idvaloresindicadoresconfigfecha->removeElement($idvaloresindicadoresconfigfecha);
    }

    /**
     * Get idvaloresindicadoresconfigfecha
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdvaloresindicadoresconfigfecha()
    {
        return $this->idvaloresindicadoresconfigfecha;
    }

    /**
     * Add idindicador
     *
     * @param \AppBundle\Entity\Indicadores $idindicador
     * @return Desgloces
     */
    public function addIdindicador(\AppBundle\Entity\Indicadores $idindicador)
    {
        $this->idindicador[] = $idindicador;

        return $this;
    }

    /**
     * Remove idindicador
     *
     * @param \AppBundle\Entity\Indicadores $idindicador
     */
    public function removeIdindicador(\AppBundle\Entity\Indicadores $idindicador)
    {
        $this->idindicador->removeElement($idindicador);
    }

    /**
     * Get idindicador
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdindicador()
    {
        return $this->idindicador;
    }
}
