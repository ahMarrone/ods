<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Metas
 */
class Metas
{
    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var integer
     */
    private $idMeta;

    /**
     * @var \AppBundle\Entity\Objetivos
     */
    private $fkObjetivo;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Metas
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
     * Get idMeta
     *
     * @return integer 
     */
    public function getIdMeta()
    {
        return $this->idMeta;
    }

    /**
     * Set fkObjetivo
     *
     * @param \AppBundle\Entity\Objetivos $fkObjetivo
     * @return Metas
     */
    public function setFkObjetivo(\AppBundle\Entity\Objetivos $fkObjetivo = null)
    {
        $this->fkObjetivo = $fkObjetivo;

        return $this;
    }

    /**
     * Get fkObjetivo
     *
     * @return \AppBundle\Entity\Objetivos 
     */
    public function getFkObjetivo()
    {
        return $this->fkObjetivo;
    }
}
