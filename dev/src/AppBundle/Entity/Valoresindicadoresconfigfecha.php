<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Valoresindicadoresconfigfecha
 */
class Valoresindicadoresconfigfecha
{
    /**
     * @var string
     */
    private $fecha;

    /**
     * @var boolean
     */
    private $cruzado;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Indicadores
     */
    private $idindicador;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $iddesgloce;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->iddesgloce = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Valoresindicadoresconfigfecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set cruzado
     *
     * @param boolean $cruzado
     * @return Valoresindicadoresconfigfecha
     */
    public function setCruzado($cruzado)
    {
        $this->cruzado = $cruzado;

        return $this;
    }

    /**
     * Get cruzado
     *
     * @return boolean 
     */
    public function getCruzado()
    {
        return $this->cruzado;
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
     * Set idindicador
     *
     * @param \AppBundle\Entity\Indicadores $idindicador
     * @return Valoresindicadoresconfigfecha
     */
    public function setIdindicador(\AppBundle\Entity\Indicadores $idindicador = null)
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
     * Add iddesgloce
     *
     * @param \AppBundle\Entity\Desgloces $iddesgloce
     * @return Valoresindicadoresconfigfecha
     */
    public function addIddesgloce(\AppBundle\Entity\Desgloces $iddesgloce)
    {
        $this->iddesgloce[] = $iddesgloce;

        return $this;
    }

    /**
     * Remove iddesgloce
     *
     * @param \AppBundle\Entity\Desgloces $iddesgloce
     */
    public function removeIddesgloce(\AppBundle\Entity\Desgloces $iddesgloce)
    {
        $this->iddesgloce->removeElement($iddesgloce);
    }

    /**
     * Get iddesgloce
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIddesgloce()
    {
        return $this->iddesgloce;
    }
}
