<?php


namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

class IndicadoresRepository extends EntityRepository
{
    
        public function findAll($visible=false,$idSet=array())
            {
                $rsm = new ResultSetMapping;
                $rsm->addEntityResult('AppBundle:indicadores', 'i');
                $rsm->addFieldResult('i', 'id', 'id');
                $rsm->addFieldResult('i', 'codigo', 'codigo');
                $rsm->addFieldResult('i', 'descripcion', 'descripcion');
                $rsm->addFieldResult('i', 'tipo', 'tipo');
                $rsm->addFieldResult('i', 'valMin', 'valmin');
                $rsm->addFieldResult('i', 'valMax', 'valmax');
                $rsm->addFieldResult('i', 'ambito', 'ambito');
                $rsm->addFieldResult('i', 'visible', 'visible');
                $rsm->addFieldResult('i', 'fechaModificacion', 'fechamodificacion');
                $rsm->addFieldResult('i', 'fechasDestacadas', 'fechasdestacadas');
                $rsm->addFieldResult('i', 'fechaMetaIntermedia', 'fechametaintermedia');
                $rsm->addFieldResult('i', 'valorEsperadoMetaIntermedia', 'valoresperadometaintermedia');
                $rsm->addFieldResult('i', 'fechaMetaFinal', 'fechametafinal');
                $rsm->addFieldResult('i', 'valorEsperadoMetaFinal', 'valoresperadometafinal');
                $rsm->addFieldResult('i', 'documentpath', 'documentpath');
                $rsm->addMetaResult('i', 'fkIdMeta', 'fkIdMeta');
                $rsm->addMetaResult('i', 'idUsuario', 'idUsuario');

                if ($visible) {
                $sql = 'SELECT * FROM (SELECT * from indicadores WHERE id IN (?) AND visible=true) AS i INNER JOIN (SELECT id AS idMeta, fkIdObjetivo, codigo AS codigoMeta FROM metas) AS m ON idMeta = fkIdMeta ORDER BY fkIdObjetivo, cast(codigoMeta AS unsigned), codigoMeta, cast(codigo AS unsigned), codigo';
                } else {
                    $sql = 'SELECT * FROM (SELECT * from indicadores) AS i INNER JOIN (SELECT id AS idMeta, fkIdObjetivo, codigo AS codigoMeta FROM metas) AS m ON idMeta = fkIdMeta ORDER BY fkIdObjetivo, cast(codigoMeta AS unsigned), codigoMeta, cast(codigo AS unsigned), codigo';
                }
                
                $query = $this->getEntityManager()->createNativeQuery($sql, $rsm);
                $query->setParameter(1, $idSet);
                return $query->getResult();
                // return $this->findBy(array(), array('codigo' => 'ASC'));
            }
}