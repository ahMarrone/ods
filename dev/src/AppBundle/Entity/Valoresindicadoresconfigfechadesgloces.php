<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * valoresIndicadoresConfigFechaDesgloces
 */
class Valoresindicadoresconfigfechadesgloces
{
    /**
     * @var integer
     */
    private $iddesgloce;

    /**
     * @var integer
     */
    private $idvaloresindicadoresconfigfecha;


    /**
     * Set iddesgloce
     *
     * @param integer $iddesgloce
     * @return Valoresindicadoresconfigfechadesgloces
     */
    public function setIddesgloce($iddesgloce)
    {
        $this->iddesgloce = $iddesgloce;

        return $this;
    }

    /**
     * Get iddesgloce
     *
     * @return integer 
     */
    public function getIddesgloce()
    {
        return $this->iddesgloce;
    }

    /**
     * Set idvaloresindicadoresconfigfecha
     *
     * @param integer $idvaloresindicadoresconfigfecha
     * @return Valoresindicadoresconfigfechadesgloces
     */
    public function setIdvaloresindicadoresconfigfecha($idvaloresindicadoresconfigfecha)
    {
        $this->idvaloresindicadoresconfigfecha = $idvaloresindicadoresconfigfecha;

        return $this;
    }

    /**
     * Get idvaloresindicadoresconfigfecha
     *
     * @return integer 
     */
    public function getIdvaloresindicadoresconfigfecha()
    {
        return $this->idvaloresindicadoresconfigfecha;
    }
}
