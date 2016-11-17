<?php


namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;


class ExploraRepository extends EntityRepository
{
    public function filterEtiquetasByIndicador($idIndicador) {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT e FROM AppBundle:Etiquetas e WHERE 
                e.fkiddesgloce IN (
                    SELECT d.iddesgloce FROM AppBundle:Desglocesindicadores d WHERE
                    d.idindicador = :idIndicador)'
                )->setParameter('idIndicador', $idIndicador)
                ->getResult();
    }
}