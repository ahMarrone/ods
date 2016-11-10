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
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $idUsuario;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $id1;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idUsuario = new \Doctrine\Common\Collections\ArrayCollection();
        $this->id1 = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add idUsuario
     *
     * @param \AppBundle\Entity\Usuarios $idUsuario
     * @return Refgeografica
     */
    public function addIdUsuario(\AppBundle\Entity\Usuarios $idUsuario)
    {
        $this->idUsuario[] = $idUsuario;

        return $this;
    }

    /**
     * Remove idUsuario
     *
     * @param \AppBundle\Entity\Usuarios $idUsuario
     */
    public function removeIdUsuario(\AppBundle\Entity\Usuarios $idUsuario)
    {
        $this->idUsuario->removeElement($idUsuario);
    }

    /**
     * Get idUsuario
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    /**
     * Add id1
     *
     * @param \AppBundle\Entity\Refgeografica $id1
     * @return Refgeografica
     */
    public function addId1(\AppBundle\Entity\Refgeografica $id1)
    {
        $this->id1[] = $id1;

        return $this;
    }

    /**
     * Remove id1
     *
     * @param \AppBundle\Entity\Refgeografica $id1
     */
    public function removeId1(\AppBundle\Entity\Refgeografica $id1)
    {
        $this->id1->removeElement($id1);
    }

    /**
     * Get id1
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getId1()
    {
        return $this->id1;
    }
}
