<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RefGeografica
 */
class RefGeografica
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
    private $idRefgeografica;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return RefGeografica
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
     * @return RefGeografica
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
     * @return RefGeografica
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
     * Get idRefgeografica
     *
     * @return integer 
     */
    public function getIdRefgeografica()
    {
        return $this->idRefgeografica;
    }
}
