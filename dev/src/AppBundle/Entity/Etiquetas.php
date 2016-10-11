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
    private $idEtiqueta;

    /**
     * @var \AppBundle\Entity\Desgloces
     */
    private $fkDesgloce;


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
     * Get idEtiqueta
     *
     * @return integer 
     */
    public function getIdEtiqueta()
    {
        return $this->idEtiqueta;
    }

    /**
     * Set fkDesgloce
     *
     * @param \AppBundle\Entity\Desgloces $fkDesgloce
     * @return Etiquetas
     */
    public function setFkDesgloce(\AppBundle\Entity\Desgloces $fkDesgloce = null)
    {
        $this->fkDesgloce = $fkDesgloce;

        return $this;
    }

    /**
     * Get fkDesgloce
     *
     * @return \AppBundle\Entity\Desgloces 
     */
    public function getFkDesgloce()
    {
        return $this->fkDesgloce;
    }
}
