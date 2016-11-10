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
    private $id;

    /**
     * @var \AppBundle\Entity\Objetivos
     */
    private $fkidobjetivo;


    /**
    * @var string
    */
    private $ido;


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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fkidobjetivo
     *
     * @param \AppBundle\Entity\Objetivos $fkidobjetivo
     * @return Metas
     */
    public function setFkidobjetivo(\AppBundle\Entity\Objetivos $fkidobjetivo = null)
    {
        $this->fkidobjetivo = $fkidobjetivo;
        return $this;
    }

    /**
     * Get fkidobjetivo
     *
     * @return \AppBundle\Entity\Objetivos 
     */
    public function getFkidobjetivo()
    {
        return $this->fkidobjetivo;
    }


    public function __toString(){
        return (string) $this->getId() . ' - ' . substr($this->getDescripcion(), 0, 15);
    }



    /**
     * Get fkidobjetivo
     *
     * @return string
     */
    public function getIdobjetivo_str()
    {
        $this->ido = (string) $this->fkidobjetivo;
        return $this->ido;
    }
}
