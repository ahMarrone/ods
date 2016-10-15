<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etiquetas
 */
class Etiquetas
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
     * @var \AppBundle\Entity\Desgloces
     */
    private $fkiddesgloce;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Etiquetas
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

    /**
     * Set fkiddesgloce
     *
     * @param \AppBundle\Entity\Desgloces $fkiddesgloce
     * @return Etiquetas
     */
    public function setFkiddesgloce(\AppBundle\Entity\Desgloces $fkiddesgloce = null)
    {
        $this->fkiddesgloce = $fkiddesgloce;

        return $this;
    }

    /**
     * Get fkiddesgloce
     *
     * @return \AppBundle\Entity\Desgloces 
     */
    public function getFkiddesgloce()
    {
        return $this->fkiddesgloce;
    }

    public function __toString(){
        return (string) $this->getId() . ' - ' . substr($this->getDescripcion(), 0, 20);
    }
    
}
