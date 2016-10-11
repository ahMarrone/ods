<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ValoresIndicadores
 */
class ValoresIndicadores
{
    /**
     * @var \DateTime
     */
    private $anio;

    /**
     * @var boolean
     */
    private $mes;

    /**
     * @var string
     */
    private $valor;

    /**
     * @var boolean
     */
    private $aprobado;

    /**
     * @var \AppBundle\Entity\Etiquetas
     */
    private $idEtiqueta;

    /**
     * @var \AppBundle\Entity\Indicadores
     */
    private $idIndicador;

    /**
     * @var \AppBundle\Entity\RefGeografica
     */
    private $idRefgeografica;


    /**
     * Set anio
     *
     * @param \DateTime $anio
     * @return ValoresIndicadores
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;

        return $this;
    }

    /**
     * Get anio
     *
     * @return \DateTime 
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * Set mes
     *
     * @param boolean $mes
     * @return ValoresIndicadores
     */
    public function setMes($mes)
    {
        $this->mes = $mes;

        return $this;
    }

    /**
     * Get mes
     *
     * @return boolean 
     */
    public function getMes()
    {
        return $this->mes;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return ValoresIndicadores
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return string 
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set aprobado
     *
     * @param boolean $aprobado
     * @return ValoresIndicadores
     */
    public function setAprobado($aprobado)
    {
        $this->aprobado = $aprobado;

        return $this;
    }

    /**
     * Get aprobado
     *
     * @return boolean 
     */
    public function getAprobado()
    {
        return $this->aprobado;
    }

    /**
     * Set idEtiqueta
     *
     * @param \AppBundle\Entity\Etiquetas $idEtiqueta
     * @return ValoresIndicadores
     */
    public function setIdEtiqueta(\AppBundle\Entity\Etiquetas $idEtiqueta)
    {
        $this->idEtiqueta = $idEtiqueta;

        return $this;
    }

    /**
     * Get idEtiqueta
     *
     * @return \AppBundle\Entity\Etiquetas 
     */
    public function getIdEtiqueta()
    {
        return $this->idEtiqueta;
    }

    /**
     * Set idIndicador
     *
     * @param \AppBundle\Entity\Indicadores $idIndicador
     * @return ValoresIndicadores
     */
    public function setIdIndicador(\AppBundle\Entity\Indicadores $idIndicador)
    {
        $this->idIndicador = $idIndicador;

        return $this;
    }

    /**
     * Get idIndicador
     *
     * @return \AppBundle\Entity\Indicadores 
     */
    public function getIdIndicador()
    {
        return $this->idIndicador;
    }

    /**
     * Set idRefgeografica
     *
     * @param \AppBundle\Entity\RefGeografica $idRefgeografica
     * @return ValoresIndicadores
     */
    public function setIdRefgeografica(\AppBundle\Entity\RefGeografica $idRefgeografica)
    {
        $this->idRefgeografica = $idRefgeografica;

        return $this;
    }

    /**
     * Get idRefgeografica
     *
     * @return \AppBundle\Entity\RefGeografica 
     */
    public function getIdRefgeografica()
    {
        return $this->idRefgeografica;
    }
}
