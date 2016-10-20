<?php


namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ValoresindicadoresRepository extends EntityRepository
{
    public function filterByIndicadorFechaDesgloce($idIndicador, $fecha, $idDesgloce){
        return $this->getEntityManager()
            ->createQuery(
             'SELECT p FROM AppBundle:Valoresindicadores p where 
             		p.idindicador = :idIndicador 
             		and p.fecha = :fecha
					and p.idetiqueta IN 
						(SELECT e.id FROM AppBundle:Etiquetas e WHERE e.fkiddesgloce = :idDesgloce)'
            )->setParameter('idIndicador', $idIndicador)
	         ->setParameter('fecha', $fecha)
	         ->setParameter('idDesgloce', $idDesgloce)
            ->getResult();
    }


    public function findByMultipleKey($idIndicador, $idRefgeografica, $fecha){
        return $this->getEntityManager()
            ->createQuery(
             'SELECT p FROM AppBundle:Valoresindicadores p where 
                    p.idindicador = :idIndicador 
                    and p.idrefgeografica = :idRefgeografica
                    and p.fecha = :fecha'
            )->setParameter('idIndicador', $idIndicador)
             ->setParameter('fecha', $fecha)
             ->setParameter('idRefgeografica', $idRefgeografica)
            ->getResult();
    }
}