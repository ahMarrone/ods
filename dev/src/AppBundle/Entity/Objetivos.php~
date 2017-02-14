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


    // Ojo! Acá tuve que 'tocar' lo que retorna __toString() porque necesito solo el 'Id' en el CRUD de 'Indicadores'.
    // Hay que ver bien cómo controlar esto.-

    public function __toString()
    {
        return $this->getDescripcion();  
        
    }


    public function getDisplayName(){
        return $this->getId() . " - "  . $this->getDescripcion();
    }
}
