<?php


namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ValoresindicadoresRepository extends EntityRepository
{
    public function filterByIndicadorFecha($idIndicador, $fecha){
        return $this->getEntityManager()
            ->createQuery(
             'SELECT p FROM AppBundle:Valoresindicadores p where 
             		p.idindicador = :idIndicador 
             		and p.fecha = :fecha'
            )->setParameter('idIndicador', $idIndicador)
	         ->setParameter('fecha', $fecha)
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


    public function findByFullKey($idIndicador, $idRefgeografica, $fecha, $etiqueta){
        return $this->getEntityManager()
            ->createQuery(
             'SELECT p FROM AppBundle:Valoresindicadores p where 
                    p.idindicador = :idIndicador 
                    and p.idrefgeografica = :idRefgeografica
                    and p.fecha = :fecha
                    and p.idetiqueta = :idEtiqueta'
            )->setParameter('idIndicador', $idIndicador)
             ->setParameter('fecha', $fecha)
             ->setParameter('idRefgeografica', $idRefgeografica)
             ->setParameter('idEtiqueta',$etiqueta)
            ->getResult();
    }

    // Retorna fechas en las cuales el indicador tiene valoresindicadores cargados
    public function getIndicadorDates($idIndicador){
        return $this->getEntityManager()
            ->createQuery(
             'SELECT DISTINCT p.fecha FROM AppBundle:Valoresindicadores p where 
                    p.idindicador = :idIndicador ORDER BY p.fecha'
            )->setParameter('idIndicador', $idIndicador)
            ->getResult();
    }

}