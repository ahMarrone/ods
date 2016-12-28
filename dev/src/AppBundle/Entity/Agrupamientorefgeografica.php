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
    private $id_1;

    /**
     * @var integer
     */
    private $id_2;


    /**
     * Set id_1
     *
     * @param integer $id1
     * @return Agrupamientorefgeografica
     */
    public function setId1($id1)
    {
        $this->id_1 = $id1;

        return $this;
    }

    /**
     * Get id_1
     *
     * @return integer 
     */
    public function getId1()
    {
        return $this->id_1;
    }

    /**
     * Set id_2
     *
     * @param integer $id2
     * @return Agrupamientorefgeografica
     */
    public function setId2($id2)
    {
        $this->id_2 = $id2;

        return $this;
    }

    /**
     * Get id_2
     *
     * @return integer 
     */
    public function getId2()
    {
        return $this->id_2;
    }
}
