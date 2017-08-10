<?php


namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ValoresindicadoresRepository extends EntityRepository
{
    public function filterByIndicadorFecha($idIndicador, $fecha){
        $idConfig = $this->getEntityManager()
            ->createQuery(
             'SELECT p.id FROM AppBundle:Valoresindicadoresconfigfecha p where 
                    p.idindicador = :idIndicador 
                    and p.fecha = :fecha'
            )->setParameter('idIndicador', $idIndicador)
             ->setParameter('fecha', $fecha)
            ->getResult();
        return $this->getEntityManager()
            ->createQuery(
             'SELECT p FROM AppBundle:Valoresindicadores p where 
             		p.idvaloresindicadoresconfigfecha = :idvaloresindicadoresconfigfecha' 
            )->setParameter('idvaloresindicadoresconfigfecha', $idConfig)
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
             'SELECT DISTINCT p.fecha FROM AppBundle:Valoresindicadoresconfigfecha p where 
                    p.idindicador = :idIndicador ORDER BY p.fecha'
            )->setParameter('idIndicador', $idIndicador)
            ->getResult();
    }

    public function getIndicadoresDataToApprove(){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('c')
           ->from('AppBundle:Valoresindicadoresconfigfecha', 'c')
           ->innerJoin('AppBundle:Valoresindicadores', 'v', 'WITH', 'c.id = v.idvaloresindicadoresconfigfecha')
           ->where('v.aprobado = 0')
           ->groupBy('c.idindicador');
        $query = $qb->getQuery(); 
        return $query->getResult();
    }

    public function getIndicadoresHasData($idIndicador = -1){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('c')
           ->from('AppBundle:Valoresindicadoresconfigfecha', 'c')
           ->innerJoin('AppBundle:Valoresindicadores', 'v', 'WITH', 'c.id = v.idvaloresindicadoresconfigfecha')
           ->groupBy('c.idindicador');
        if ($idIndicador != -1){
            $qb->where('c.idindicador = ?1');
            $qb->setParameter(1,$idIndicador);
        }
        $query = $qb->getQuery(); 
        return $query->getResult();
    }

}