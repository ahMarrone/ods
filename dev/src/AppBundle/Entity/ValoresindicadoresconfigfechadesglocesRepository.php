<?php


namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ValoresindicadoresconfigfechadesglocesRepository extends EntityRepository
{
    public function findByIdValoresIndicadoresConfig($idIndicador, $fecha){
        return $this->getEntityManager()
            ->createQuery(
             'SELECT p FROM AppBundle:Valoresindicadoresconfigfecha p where 
                    p.idindicador = :idIndicador 
                    and p.fecha = :fecha'
            )->setParameter('idIndicador', $idIndicador)
             ->setParameter('fecha', $fecha)
            ->getResult();
    }
}