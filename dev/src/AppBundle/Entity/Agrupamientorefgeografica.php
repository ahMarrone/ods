<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agrupamientorefgeografica
 */
class Agrupamientorefgeografica
{
    /**
     * @var integer
     */
    private $id1;

    /**
     * @var integer
     */
    private $id2;


    /**
     * Set id1
     *
     * @param integer $id1
     * @return Agrupamientorefgeografica
     */
    public function setId1($id1)
    {
        $this->id1 = $id1;

        return $this;
    }

    /**
     * Get id1
     *
     * @return integer 
     */
    public function getId1()
    {
        return $this->id1;
    }

    /**
     * Set id2
     *
     * @param integer $id2
     * @return Agrupamientorefgeografica
     */
    public function setId2($id2)
    {
        $this->id2 = $id2;

        return $this;
    }

    /**
     * Get id2
     *
     * @return integer 
     */
    public function getId2()
    {
        return $this->id2;
    }
}
