<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ExploraController extends Controller
{
    /**
     * @Route("/explora/{idIndicador}", name="explora", requirements={"idIndicador": "\d+"})
     */
    public function exploraAction(Request $request, $idIndicador)
    {
        // echo var_dump($idIndicador);

        /* Recuperar Metas, Objetivos, Indicadores y Etiquetas para rellenar 'selects' */

        return $this->render('explora/explora.html.twig', array(
            'objetivos' => $this->getObjetivosPreload(),
            'metas' => $this->getMetasPreload(),
            'indicadores' => $this->getIndicadoresPreload(1),
            'etiquetas' => $this->getEtiquetasByIndicadorPreload($idIndicador),
            'indicador' => $this->$idIndicador
            // 'indicadorSeleccionado' => $idIndicador
        ));
    }

    private function getObjetivosPreload(){
        $list = array();
        $objetivos =  $this->getDoctrine()->getRepository('AppBundle:Objetivos')->findAll();
        foreach ($objetivos as $o) {
            array_push($list, array(
                'id'=>$o->getId(),
                'desc'=>$o->getDescripcion())
            );
        }
        return $list;
    }

    private function getMetasPreload(){
        $list = array();
        $metas =  $this->getDoctrine()->getRepository('AppBundle:Metas')->findAll();
        foreach ($metas as $m) {
            array_push($list, array(
                'id'=>$m->getId(),
                'desc'=>$m->getDescripcion(),
                'id_objetivo'=>$m->getFkidobjetivo()->getId())
            );
        }
        return $list;
    }

    private function getIndicadoresPreload($idMeta){
        $list = array();
        $indicadores =  $this->getDoctrine()->getRepository('AppBundle:Indicadores')->findOneById($idMeta);
        foreach ($indicadores as $i) {
            array_push($list, array(
                'id'=>$i->getId(),
                'desc'=>$i->getDescripcion(),
                'id_meta'=>$i->getFkidmeta()->getId()));
        }
        return $list;
    }

    private function getEtiquetasByIndicadorPreload($idIndicador){
        $etiquetasEntity = $this->filterEtiquetasByIndicador($idIndicador);
        $etiquetas = array();
        foreach ($etiquetasEntity as $e){
            array_push($etiquetas, array(
                'idEtiqueta' => $e->getId(),
                'descripcion' => $e->getDescripcion())
            );
            
        }
        return $etiquetas;
    }

    /* Consultas */

    private function filterEtiquetasByIndicador($idIndicador) {
        return $this->getDoctrine()->getManager()->createQuery(
                'SELECT e FROM AppBundle:Etiquetas e WHERE 
                e.fkiddesgloce IN (
                    SELECT d.iddesgloce FROM AppBundle:Desglocesindicadores d WHERE
                    d.idindicador = :idIndicador)'
                )->setParameter('idIndicador', $idIndicador)
                ->getResult();
    }

    private function filterIndicadoresByMetas($idMeta) {
        return $this->getDoctrine()->getManager()->createQuery(
                'SELECT i FROM AppBundle:Indicadores i WHERE 
                i.fkidmeta = :idMeta)'
                )->setParameter('idMeta', $idMeta)
                ->getResult();
    }

}
// http://librosweb.es/libro/symfony_2_x/capitulo_8/buscando_objetos.html