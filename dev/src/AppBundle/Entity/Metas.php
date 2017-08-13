<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

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
     * @var string
     */
    private $codigo;

    /**
     * @var \AppBundle\Entity\Objetivos
     */
    private $fkidobjetivo;

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
     * @var string
     */
    private $fechamodificacion;

    /**
     * @var \AppBundle\Entity\Usuarios
     */
    private $idusuario;


    /**
     * Set fechamodificacion
     *
     * @param string $fechamodificacion
     * @return Metas
     */
    public function setFechamodificacion($fechamodificacion)
    {
        $this->fechamodificacion = $fechamodificacion;

        return $this;
    }

    /**
     * Get fechamodificacion
     *
     * @return string 
     */
    public function getFechamodificacion()
    {
        return $this->fechamodificacion;
    }

    /**
     * Set idusuario
     *
     * @param \AppBundle\Entity\Usuarios $idusuario
     * @return Metas
     */
    public function setIdusuario(\AppBundle\Entity\Usuarios $idusuario = null)
    {
        $this->idusuario = $idusuario;

        return $this;
    }

    /**
     * Get idusuario
     *
     * @return \AppBundle\Entity\Usuarios 
     */
    public function getIdusuario()
    {
        return $this->idusuario;
    }
    /**
     * @var string
     */
    private $ambito;


    /**
     * Set ambito
     *
     * @param string $ambito
     * @return Metas
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
     * Set codigo
     *
     * @param string $codigo
     * @return Metas
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }


    public function formatCodigo($codigo){
        $prefix = "0000";
        if (!is_numeric(substr($codigo,0,1))){
            $prefix = "9999";
        }
        $newCodigo = $prefix . $codigo;
        return $newCodigo;
    }


    public function getVisibleCodigo(){
        return substr($this->getCodigo(),4);
    }

}
