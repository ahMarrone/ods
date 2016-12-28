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

        /* ENCONTRAR UNA SOLUCIÓN MÁS ELEGANTE */

        $reverseDesgloses = array();
        $etiquetas = $this->getEtiquetasByIndicadorPreload($idIndicador, $reverseDesgloses);

        /* PASAR TODOS A VARIABLES */

        return $this->render('explora/explora.html.twig', array(
            'objetivos' => $this->getObjetivosPreload(),
            'metas' => $this->getMetasPreload(),
            'indicadores' => $this->getIndicadoresPreload($idMetaSeleccionada),
            'desgloses' => $this->getDesglosesByIndicadorPreload($idIndicador),
            'etiquetas' => $etiquetas,
            'valoresIndicadoresDesgloses' => $this->getValoresIndicadoresDesgloses($idIndicador, $reverseDesgloses),
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

    private function parseFechasDestacadas($fechasDestacadasStr) {
        $fechasDestacadas = array();
        $parseResult = explode(";", $fechasDestacadasStr);
        foreach ($parseResult as $fecha) {
            array_push($fechasDestacadas, date('Y', strtotime($fecha)));
        }
        return $fechasDestacadas;
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
            /* CONSTRUIR ESCALA A PARTIR DE valMin y ValMax */
            $list[$idIndicador]['escala'] = array(0, 20, 40, 60, 80);
            $list[$idIndicador]['fechasDestacadas'] = $this->parseFechasDestacadas($i->getFechasDestacadas());
            // $list[$idIndicador]['metas'] = array($i->getFechaMetaIntemedia => floatval($i->getValorEsperadoMetaIntermedia), $i->getFechaMetaFinal => floatval($i->getValorEsperadoMetaFinal));
        }
        return $list;
    }

    private function getEtiquetasByIndicadorPreload($idIndicador, &$reverseDesgloses){
        $etiquetasEntity = $this->filterEtiquetasByIndicador($idIndicador);
        $etiquetas = array();
        $desgloses = array();
        $maximoID = 0;
        foreach ($etiquetasEntity as $e){
            array_push($etiquetas, array(
                'id' => $e->getId(),
                'descripcion' => $e->getDescripcion(),
                'id_desglose' => $e->getFkiddesgloce()->getId())
            );
            $maximoID = max($maximoID, $e->getId());
            array_push($desgloses, $e->getFkiddesgloce()->getId());
        }

        $desgloses = array_unique($desgloses);

        foreach ($desgloses as $idDesglose) {
            $maximoID += 1;
            array_push($etiquetas, array(
                'id' => $maximoID,
                'descripcion' => 'Todos',
                'id_desglose' => $idDesglose)
            );

            array_push($reverseDesgloses, array(
                'id' => $idDesglose,
                'id_etiqueta' => $maximoID)
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

    private function getValoresIndicadoresDesgloses($idIndicador, $reverseDesgloses){
        $entidad = $this->filterValoresIndicadoresConfigFechaByIndicador($idIndicador);
        $atributos = array();
        $atributosPorFecha = array();
        /* ORDENARLOS POR IDS! */
        $idsValoresIndicadoresConfigFecha = array(); /* Lista de IDs */

        foreach ($entidad as $e){
            $id = $e->getId();
            array_push($idsValoresIndicadoresConfigFecha, $id);
            /* Parsear 'fecha', conservando solo el año */
            $fecha = explode('-', $e->getFecha())[0];
            $atributos[$id] = array('fecha' => $fecha);
            $atributosPorFecha[$fecha] = array('id_desgloses' => array(),
                'valoresRefGeografica' => array());
        }

        $entidad = $this->filterValoresIndicadoresConfigDesglosesFechaByIdsSet($idsValoresIndicadoresConfigFecha);
        foreach ($entidad as $e){
            $idValoresIndicadoresConfigFecha = $e->getIdValoresIndicadoresConfigFecha();
            $idDesglose = $e->getIdDesgloce();
            $fecha = $atributos[$idValoresIndicadoresConfigFecha]['fecha'];
            array_push($atributosPorFecha[$fecha]['id_desgloses'], $idDesglose);
        }

        $entidad = $this->filterValoresIndicadoresByIdsSet($idsValoresIndicadoresConfigFecha);
        foreach ($entidad as $e){
            $idValoresIndicadoresConfigFecha = $e->getIdValoresIndicadoresConfigFecha()->getId();
            $idRefGeografica = $e->getIdRefGeografica()->getId();
            $idEtiqueta = $e->getIdEtiqueta();
            $valor = $e->getValor();
            $fecha = $atributos[$idValoresIndicadoresConfigFecha]['fecha'];
            // echo (var_dump($idRefGeografica));
            /* Valor es String en la entidad, ¿por qué?*/
            $atributosPorFecha[$fecha]['valoresRefGeografica'][$idRefGeografica][$idEtiqueta] = floatval($valor);            
        }

        $desglosesAcumulados = $this->sumValoresIndicadores($idsValoresIndicadoresConfigFecha);
        foreach ($desglosesAcumulados as $columnas) {
            $idValoresIndicadoresConfigFecha = $columnas['idValoresIndicadoresConfigFecha'];
            $fecha = $atributos[$idValoresIndicadoresConfigFecha]['fecha'];
            $idRefGeografica = $columnas['idRefGeografica'];
            $idDesglose = $columnas['idDesglose'];
            $idEtiquetaAcumulado = $reverseDesgloses[$idDesglose]['id_etiqueta'];
            $atributosPorFecha[$fecha]['valoresRefGeografica'][$idRefGeografica][$idEtiquetaAcumulado] = floatval($columnas['acumulado']);
        }

        return $atributosPorFecha;
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

    private function sumValoresIndicadores($idsSet) {

        return $this->getDoctrine()->getManager()->getConnection()->executeQuery(
            'SELECT idValoresIndicadoresConfigFecha, idRefGeografica, fkIdDesgloce AS idDesglose, SUM(valor) AS acumulado FROM (SELECT idValoresIndicadoresConfigFecha, idEtiqueta, idRefGeografica, valor FROM valoresIndicadores WHERE idValoresIndicadoresConfigFecha IN (?)) AS TLeft INNER JOIN etiquetas as TRight ON TLeft.idEtiqueta = TRight.id GROUP BY idValoresIndicadoresConfigFecha, idRefGeografica, fkIdDesgloce',
            array($idsSet),
            array(\Doctrine\DBAL\Connection::PARAM_INT_ARRAY)
            )->fetchAll();
    }
}
// http://librosweb.es/libro/symfony_2_x/capitulo_8/buscando_objetos.html


