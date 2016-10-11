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
    private $idDesgloce;


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
     * Get idDesgloce
     *
     * @return integer 
     */
    public function getIdDesgloce()
    {
        return $this->idDesgloce;
    }
}
