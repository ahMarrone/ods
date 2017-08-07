<?php


namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

class MetasRepository extends EntityRepository
{
        public function findAll()
            {
            $rsm = new ResultSetMapping;
            $rsm->addEntityResult('AppBundle:metas', 'm');
            $rsm->addFieldResult('m', 'id', 'id');
            $rsm->addFieldResult('m', 'codigo', 'codigo');
            $rsm->addFieldResult('m', 'descripcion', 'descripcion');
            $rsm->addFieldResult('m', 'ambito', 'ambito');
            $rsm->addFieldResult('m', 'fechaModificacion', 'fechamodificacion');
            $rsm->addMetaResult('m', 'fkIdObjetivo', 'fkIdObjetivo');
            $rsm->addMetaResult('m', 'idUsuario', 'idUsuario');

            return $this->getEntityManager()
            ->createNativeQuery(
             'SELECT * from metas ORDER BY fkIdObjetivo, cast(codigo as unsigned), codigo',$rsm
            )->getResult();

            // return $this->findBy(array(), array('codigo' => 'ASC'));
            }
}