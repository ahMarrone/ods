<?php


namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class MetasRepository extends EntityRepository
{
    
        public function findAll()
            {
                return $this->findBy(array(), array('codigo' => 'ASC'));
            }
}