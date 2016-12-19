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

        $reverseSearchResult = $this->reverseSearchByIndicador($idIndicador)[0];
        $idObjetivoSeleccionado = $reverseSearchResult['objetivo'];
        $idMetaSeleccionada = $reverseSearchResult['meta'];

        return $this->render('explora/explora.html.twig', array(
            'objetivos' => $this->getObjetivosPreload(),
            'metas' => $this->getMetasPreload(),
            'indicadores' => $this->getIndicadoresPreload($idMetaSeleccionada),
            'desgloses' => $this->getDesglosesByIndicadorPreload($idIndicador),
            'etiquetas' => $this->getEtiquetasByIndicadorPreload($idIndicador),
            'valoresIndicadoresDesgloses' => $this->getValoresIndicadoresDesgloses($idIndicador),
            'idObjetivoSeleccionado' => $idObjetivoSeleccionado,
            'idMetaSeleccionada' => $idMetaSeleccionada,
            'idIndicadorSeleccionado' => $idIndicador
        ));
    }

    /* CAMBIAR ESQUEMA DE DICCIONARIOS - REVISAR PROBLEMA C0N CLAVE 0 */

    private function getObjetivosPreload(){
        $list = array();
        $objetivos =  $this->getDoctrine()->getRepository('AppBundle:Objetivos')->findAll();
        foreach ($objetivos as $o) {
            array_push($list, array(
                'id'=>$o->getId(),
                'descripcion'=>$o->getDescripcion())
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
                'descripcion'=>$m->getDescripcion(),
                'id_objetivo'=>$m->getFkidobjetivo()->getId())
            );
        }
        return $list;
    }

    private function getIndicadoresPreload($idMeta){
        $list = array();
        /* Si se desean filtrar por los indicadores por meta seleccionada  */
        /*$indicadores =  $this->getDoctrine()->getRepository('AppBundle:Indicadores')->findByFkidmeta($idMeta);*/
        $indicadores =  $this->getDoctrine()->getRepository('AppBundle:Indicadores')->findall();

        foreach ($indicadores as $i) {
            $idIndicador = $i->getId();
            $list[$idIndicador] = array();
            $list[$idIndicador]['descripcion'] = $i->getDescripcion();
            $list[$idIndicador]['id_meta'] = $i->getFkidmeta()->getId();
            $list[$idIndicador]['ambito'] = $i->getAmbito();
        }
        return $list;
    }

    private function getEtiquetasByIndicadorPreload($idIndicador){
        $etiquetasEntity = $this->filterEtiquetasByIndicador($idIndicador);
        $etiquetas = array();
        foreach ($etiquetasEntity as $e){
            array_push($etiquetas, array(
                'id' => $e->getId(),
                'descripcion' => $e->getDescripcion(),
                'id_desglose' => $e->getFkiddesgloce()->getId())
            );
            
        }
        return $etiquetas;
    }

    private function getDesglosesByIndicadorPreload($idIndicador){
        $desglosesEntity = $this->filterDesglosesByIndicador($idIndicador);
        $desgloses = array();
        foreach ($desglosesEntity as $d){
            array_push($desgloses, array(
                'id' => $d->getId(),
                'descripcion' => $d->getDescripcion())
            );
            
        }
        return $desgloses;
    }

    private function getValoresIndicadoresDesgloses($idIndicador){
        $entidad = $this->filterValoresIndicadoresConfigFechaByIndicador($idIndicador);
        $atributos = array();
        /* ORDENARLOS POR IDS! */
        $idsValoresIndicadoresConfigFecha = array(); /* Lista de IDs */

        foreach ($entidad as $e){
            $id = $e->getId();
            array_push($idsValoresIndicadoresConfigFecha, $id);
            /* Parsear 'fecha', conservando solo el año */
            $anio = explode('-', $e->getFecha())[0];
            $atributos[$id] = array('fecha' => $anio, 'id_desgloses' => array(),
                'valoresRefGeografica' => array());
        }

        $entidad = $this->filterValoresIndicadoresConfigDesglosesFechaByIdsSet($idsValoresIndicadoresConfigFecha);
        foreach ($entidad as $e){
            $idValoresIndicadoresConfigFecha = $e->getIdValoresIndicadoresConfigFecha();
            $idDesglose = $e->getIdDesgloce();
            array_push($atributos[$idValoresIndicadoresConfigFecha]['id_desgloses'], $idDesglose);            
        }

        $entidad = $this->filterValoresIndicadoresByIdsSet($idsValoresIndicadoresConfigFecha);
        foreach ($entidad as $e){
            $idValoresIndicadoresConfigFecha = $e->getIdValoresIndicadoresConfigFecha()->getId();
            $idRefGeografica = $e->getIdRefGeografica()->getId();
            $idEtiqueta = $e->getIdEtiqueta();
            $valor = $e->getValor();
            /* Valor es String en la entidad, ¿por qué?*/
            $atributos[$idValoresIndicadoresConfigFecha]['valoresRefGeografica'][$idRefGeografica][$idEtiqueta] = floatval($valor);
        }
        return $atributos;
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

    private function filterDesglosesByIndicador($idIndicador) {
        return $this->getDoctrine()->getManager()->createQuery(
                'SELECT d FROM AppBundle:Desgloces d WHERE 
                d.id IN (
                    SELECT di.iddesgloce FROM AppBundle:Desglocesindicadores di WHERE
                    di.idindicador = :idIndicador)'
                )->setParameter('idIndicador', $idIndicador)
                ->getResult();
    }

    private function filterValoresIndicadoresConfigFechaByIndicador($idIndicador) {
        return $this->getDoctrine()->getManager()->createQuery(
                'SELECT e FROM AppBundle:Valoresindicadoresconfigfecha e WHERE 
                e.idindicador = :idIndicador'
                )->setParameter('idIndicador', $idIndicador)
                ->getResult();
    }

    private function filterValoresIndicadoresConfigDesglosesFechaByIdsSet($idsSet) {
        return $this->getDoctrine()->getManager()->createQuery(
                'SELECT e FROM AppBundle:Valoresindicadoresconfigfechadesgloces e WHERE 
                e.idvaloresindicadoresconfigfecha IN (:idsSet)'
                )->setParameter('idsSet', $idsSet)
                ->getResult();
    }

    private function filterValoresIndicadoresByIdsSet($idsSet) {
        return $this->getDoctrine()->getManager()->createQuery(
                'SELECT e FROM AppBundle:Valoresindicadores e WHERE 
                e.idvaloresindicadoresconfigfecha IN (:idsSet)'
                )->setParameter('idsSet', $idsSet)
                ->getResult();
    }

    private function reverseSearchByIndicador($idIndicador) {
        return $this->getDoctrine()->getManager()->createQuery(
                'SELECT IDENTITY(m.fkidobjetivo) as objetivo, m.id as meta FROM AppBundle:Metas m WHERE 
                m.id = (SELECT IDENTITY (i.fkidmeta) FROM AppBundle:Indicadores i WHERE 
                i.id = :idIndicador)'
                )->setParameter('idIndicador', $idIndicador)
                ->getResult();
    }
}
// http://librosweb.es/libro/symfony_2_x/capitulo_8/buscando_objetos.html