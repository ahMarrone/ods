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

        /* Recuperar Metas, Objetivos, Indicadores, Desgloses, Etiquetas junto 
        con los correspondientes valores para cada Referencia Geogŕafica de acuerdo
        al indicador seleccionado */

        $reverseSearchResult = $this->reverseSearchByIndicador($idIndicador)[0];
        $idObjetivoSeleccionado = $reverseSearchResult['objetivo'];
        $idMetaSeleccionada = $reverseSearchResult['meta'];

        /* ENCONTRAR UNA SOLUCIÓN MÁS ELEGANTE */

        $reverseDesgloses = array();
        $etiquetas = $this->getEtiquetasByIndicadorPreload($idIndicador, $reverseDesgloses);

        $objetivos = $this->getObjetivosPreload();
        $metas = $this->getMetasPreload();
        $indicadores = $this->getIndicadoresPreload($idMetaSeleccionada);
        $desgloses = $this->getDesglosesByIndicadorPreload($idIndicador);
        $valoresIndicadoresDesgloses = $this->getValoresIndicadoresDesgloses($idIndicador, $reverseDesgloses, $indicadores[$idIndicador]);

        return $this->render('explora/explora.html.twig', array(
            'objetivos' => $objetivos,
            'metas' => $metas,
            'indicadores' => $indicadores,
            'desgloses' => $desgloses,
            'etiquetas' => $etiquetas,
            'valoresIndicadoresDesgloses' => $valoresIndicadoresDesgloses,
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
        /* Si se desean filtrar los indicadores por meta seleccionada, descomentar y reemplazar  */
        // $indicadores =  $this->getDoctrine()->getRepository('AppBundle:Indicadores')->findByFkidmeta($idMeta);

        $indicadores =  $this->getDoctrine()->getRepository('AppBundle:Indicadores')->findall();

        foreach ($indicadores as $i) {
            $idIndicador = $i->getId();
            $list[$idIndicador] = array();
            $list[$idIndicador]['descripcion'] = $i->getDescripcion();
            $list[$idIndicador]['id_meta'] = $i->getFkidmeta()->getId();
            $list[$idIndicador]['ambito'] = $i->getAmbito();
            $list[$idIndicador]['documentoTecnico'] = $i->getDocumentPath();
            /* CONSTRUIR ESCALA A PARTIR DE valMin y ValMax o de acuerdo al Tipo de Indicador */
            $list[$idIndicador]['escala'] = array(0, 20, 40, 60, 80);
            $list[$idIndicador]['fechasDestacadas'] = $this->parseFechasDestacadas($i->getFechasDestacadas());
            /* Metas: Fechas/ValoresEsperados */
            $list[$idIndicador]['fechasMetas'] = array();
            if ($i->getFechametaintermedia() != NULL) {
                array_push($list[$idIndicador]['fechasMetas'], array(date('Y', strtotime($i->getFechametaintermedia())), floatval($i->getValoresperadometaintermedia())));
            }
            if ($i->getFechametafinal() != NULL) {
                array_push($list[$idIndicador]['fechasMetas'], array(date('Y', strtotime($i->getFechametafinal())), floatval($i->getValoresperadometafinal())));
            }
        }

        return $list;
    }

    private function getEtiquetasByIndicadorPreload($idIndicador, &$reverseDesgloses){
        $etiquetasEntity = $this->filterEtiquetasByIndicador($idIndicador);
        $etiquetas = array();
        $desgloses = array();
        $maximoID = 0;
        foreach ($etiquetasEntity as $e){

            $id = $e->getId();
            if ($id == 0) {
                $descripcion = 'Total';
            } else {
                $descripcion = $e->getDescripcion();
                array_push($desgloses, $e->getFkiddesgloce()->getId());
            }

            array_push($etiquetas, array(
                'id' => $id,
                'descripcion' => $descripcion,
                'id_desglose' => $e->getFkiddesgloce()->getId())
            );
            $maximoID = max($maximoID, $e->getId());

        }

        $desgloses = array_unique($desgloses);

        foreach ($desgloses as $idDesglose) {
            $maximoID += 1;
            /* Se crean nuevas etiquetas con la descripción 'Total' para cada desglose
            Para ello, se comienza desde el ID de etiqueta más alto */
            array_push($etiquetas, array(
                'id' => $maximoID,
                'descripcion' => 'Total',
                'id_desglose' => $idDesglose)
            );

            $reverseDesgloses[$idDesglose] = $maximoID;
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

    /* VER QUÉ SUCEDE CUANDO NO EXISTEN VALORES CARGADOS PARA EL INDICADOR SELECCIONADO */
    /* CONTROLAR VISIBILIDAD */

    private function getValoresIndicadoresDesgloses($idIndicador, $reverseDesgloses, &$indicador){
        $entidad = $this->filterValoresIndicadoresConfigFechaByIndicador($idIndicador);
        $atributos = array();
        $atributosPorFecha = array();
        /* ORDENARLOS POR IDS! */
        /* SOLO RECUPERAR IDs Sin Cruces */
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
            /* Valor es String en la entidad, ¿por qué?*/
            $atributosPorFecha[$fecha]['valoresRefGeografica'][$idRefGeografica][$idEtiqueta] = floatval($valor);            
        }

        $desglosesAcumulados = $this->sumValoresIndicadores($idsValoresIndicadoresConfigFecha);
        foreach ($desglosesAcumulados as $columnas) {
            $idValoresIndicadoresConfigFecha = $columnas['idValoresIndicadoresConfigFecha'];
            $fecha = $atributos[$idValoresIndicadoresConfigFecha]['fecha'];
            $idRefGeografica = $columnas['idRefGeografica'];
            $idDesglose = $columnas['idDesglose'];
            if ($idDesglose != 0) {
                /* Aquel desglose con ID = 0, corresponde a 'Sin Desglose' */
                $idEtiquetaAcumulado = $reverseDesgloses[$idDesglose];
                $atributosPorFecha[$fecha]['valoresRefGeografica'][$idRefGeografica][$idEtiquetaAcumulado] = floatval($columnas['acumulado']);
            }
        }

        $interseccion = array();
        foreach ($indicador['fechasDestacadas'] as $fecha) {
            if (array_key_exists($fecha, $atributosPorFecha)) {
                array_push($interseccion, $fecha);
            }
        }
        $indicador['fechasDestacadas'] = $interseccion;

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


