<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Refgeografica
 */
class Refgeografica
{
    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var string
     */
    private $ambito;

    /**
     * @var integer
     */
    private $agrupa;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Refgeografica
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
     * Set ambito
     *
     * @param string $ambito
     * @return Refgeografica
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
     * Set agrupa
     *
     * @param integer $agrupa
     * @return Refgeografica
     */
    public function setAgrupa($agrupa)
    {
        $this->agrupa = $agrupa;

        return $this;
    }

    /**
     * Get agrupa
     *
     * @return integer 
     */
    public function getAgrupa()
    {
        return $this->agrupa;
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
        return (string) $this->getId() . ' - ' . substr($this->getDescripcion(), 0, 20);
    }
}
