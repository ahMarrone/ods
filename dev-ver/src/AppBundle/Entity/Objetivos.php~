<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Objetivos
 */
class Objetivos
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return Objetivos
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



    public function __toString()
    {
        return (string) $this->id . " - " . substr($this->getDescripcion(), 0, 15);  
    }

}
