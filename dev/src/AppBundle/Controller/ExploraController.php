<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
* Explora Controller
*
* @Route("/explora")
*/

class ExploraController extends Controller
{
    /**
     * @Route("/", name="explora_initialize")
     */
    public function initializeAction(Request $request)
    {
        // echo var_dump($idIndicador);

        /* Recuperar Metas, Objetivos, Indicadores, Desgloses, Etiquetas junto 
        con los correspondientes valores para cada Referencia Geogŕafica de acuerdo
        al indicador seleccionado */

        $idIndicador = 1;

        $objetivos = $this->getObjetivosPreload();
        $metas = $this->getMetasPreload();
        $indicadores = $this->getIndicadoresPreload();

        /* Antes de continuar verificar si el Indicador solicitado se encuentra 'visible' */

        if (!array_key_exists($idIndicador, $indicadores)) {
            throw $this->createNotFoundException('Indicador no encontrado');
        }

        /* MODIFICAR PARA NO UTILIZAR CONSULTA SINO DATOS YA RECUPERADOS (Objetivos, Metas, Indicadores) */
        $reverseSearchResult = $this->reverseSearchByIndicador($idIndicador)[0];
        $idObjetivoSeleccionado = $reverseSearchResult['objetivo'];
        $idMetaSeleccionada = $reverseSearchResult['meta'];

        /* ENCONTRAR UNA SOLUCIÓN MÁS ELEGANTE */
        $reverseDesgloses = array();
        $etiquetas = $this->getEtiquetasByIndicadorPreload($idIndicador, $reverseDesgloses);

        $desgloses = $this->getDesglosesByIndicadorPreload($idIndicador);
        $valoresIndicadoresDesgloses = $this->getValoresIndicadoresDesgloses($idIndicador, $reverseDesgloses);
        $indicadores[$idIndicador]['fechasDestacadas'] = $this->intersectFechasDestacadas(
            $indicadores[$idIndicador]['fechasDestacadas'], array_keys($valoresIndicadoresDesgloses));

        return $this->render('explora/explora.html.twig', array(
            'objetivos' => $objetivos,
            'metas' => $metas,
            'indicadores' => $indicadores,
            'desgloses' => $desgloses,
            'etiquetas' => $etiquetas,
            'valoresIndicadoresDesgloses' => $valoresIndicadoresDesgloses,
            'idObjetivoSeleccionado' => $idObjetivoSeleccionado,
            'idMetaSeleccionada' => $idMetaSeleccionada,
            'idIndicadorSeleccionado' => $idIndicador,
            'api_urls' => array('refresh'=> $this->generateUrl('explora_refresh'),
                                'export'=> $this->generateUrl('export_refresh'))
        ));
    }

    /**
     * Refrescar 'valoresIndicadoresDesgloses' al seleccionar un nuevo 'Indicador'
     * @Route("/refresh", name="explora_refresh")
     * @Method({"GET"})
    */

    public function refreshAction(Request $request) {
        $callbackData = array();
        $idIndicador = json_decode($request->query->get('id_indicador'));

        /* Actualizar:
        *  - Indicador (Intersecar fechasDestacadas)
        *  - Desgloses
        *  - Etiquetas
        *  - ValoresIndicadoresDesgloses
        */

        if (isset($idIndicador)) {
            $reverseDesgloses = array();
            $indicador = $this->getDoctrine()->getRepository('AppBundle:Indicadores')->findOneById($idIndicador);
            $fechasDestacadasIndicador = $this->parseFechasDestacadas($indicador->getFechasDestacadas());
            $callbackData['etiquetas'] = $this->getEtiquetasByIndicadorPreload($idIndicador, $reverseDesgloses);;
            $callbackData['desgloses'] = $this->getDesglosesByIndicadorPreload($idIndicador);;
            $callbackData['valoresIndicadoresDesgloses'] = $this->getValoresIndicadoresDesgloses($idIndicador, $reverseDesgloses);
            $fechasDestacadasDefinidas = array_keys($callbackData['valoresIndicadoresDesgloses']);
            $callbackData['fechasDestacadas'] = $this->intersectFechasDestacadas($fechasDestacadasIndicador, $fechasDestacadasDefinidas);
        } else {
            throw $this->createNotFoundException('Indicador no encontrado');    
        }

        return new JsonResponse($callbackData);
    }

    /**
     * Exportar datos del Indicador
     * @Route("/export", name="export_refresh")
     * @Method({"POST"})
    */

    public function exportAction(Request $request) {
        $CSV = ";";
        $callbackData = array();
        $idIndicador = $request->query->get('id_indicador');
        $content = $request->request->all();
        // $request->request->get('var_name');
        $fileContent = "";
        $fileName = "ods_".date('dmYHis').".csv";
        /* REVISAR FUNCIÓN empty($idIndicador) */
        if ((!empty($content)) and (!empty($idIndicador))) {
            $indicador = $this->getDoctrine()->getRepository('AppBundle:Indicadores')->findOneById($idIndicador);
            $idMeta = $indicador->getFkidmeta()->getId();
            $meta = $this->getDoctrine()->getRepository('AppBundle:Metas')->findOneById($idMeta);
            $idObjetivo = $meta->getFkidobjetivo()->getId();
            $objetivo = $this->getDoctrine()->getRepository('AppBundle:Objetivos')->findOneById($idObjetivo);
            $fileContent .= 'Objetivo: ' . $objetivo->getDescripcion() . "\r\n";
            $fileContent .= 'Meta: ' . $meta->getDescripcion() . "\r\n";
            $fileContent .= 'Indicador: ' . $indicador->getDescripcion() . "\r\n";
            $fileContent .= "\r\n";

            $filter = array('idindicador' => $idIndicador, 'cruzado' => false);
            if (!(array_key_exists('todos', $content))) {
                $fecha = $content['exportar'] . '-01-01';
                $filter['fecha'] = $fecha;
            }

            $valoresIndicadoresConfigFecha = $this->getDoctrine()->getRepository('AppBundle:Valoresindicadoresconfigfecha')->findBy($filter);
            $valoresIndicadoresConfigFechaMap = array();
            foreach ($valoresIndicadoresConfigFecha as $e) {
                $id = $e->getId();
                $valoresIndicadoresConfigFechaMap[$id] = $this->getPeriodo($e->getFecha());
            }
            $idsValoresIndicadoresConfigFecha = array_keys($valoresIndicadoresConfigFechaMap);

            /* Mapping Desgloses */
            $valoresIndicadoresConfigFechaDesgloces = $this->getDoctrine()->getRepository('AppBundle:Valoresindicadoresconfigfechadesgloces')->findByIdvaloresindicadoresconfigfecha($idsValoresIndicadoresConfigFecha);

            $idsDesgloses = array();
            foreach ($valoresIndicadoresConfigFechaDesgloces as $e) {
                $id = $e->getIddesgloce();
                array_push($idsDesgloses, $id);
            }
            /* VER SI VALE LA PENA array_unique() */

            /* Mapping Etiquetas */
            $etiquetas = $this->getDoctrine()->getRepository('AppBundle:Etiquetas')->findByFkiddesgloce($idsDesgloses);
            $etiquetasMap = array();
            $etiquetasStr = "";
            $cardinalEtiquetas = 0;
            foreach ($etiquetas as $e) {
                $id = $e->getId();
                $descripcion = $e->getDescripcion();
                $etiquetasMap[$id] = array($descripcion, $cardinalEtiquetas);
                $etiquetasStr .= $descripcion . $CSV;
                $cardinalEtiquetas++;
            }
            $valores = array();
            $valores = array_fill(0, $cardinalEtiquetas, 0);
            // $database = array_fill_keys(array('dbdriver', 'dbhost', 'dbname', 'dbuser', 'dbpass'), '');

            /* Mapping Referencias Geográficas */
            $ambito = $indicador->getAmbito();
            $refGeografica = $this->getDoctrine()->getRepository('AppBundle:Refgeografica')->findByAmbito($ambito);
            $refGeograficaMap = array();
            foreach ($refGeografica as $e) {
                $id = $e->getId();
                $refGeograficaMap[$id] = $e->getDescripcion();
            }
            // echo var_dump($idsValoresIndicadoresConfigFecha);

            /* ORDENAR POR ID, IDREFGEO */
            $valoresIndicadores = $this->getDoctrine()->getRepository('AppBundle:Valoresindicadores')->findBy(
                array('idvaloresindicadoresconfigfecha' => $idsValoresIndicadoresConfigFecha, 
                      'aprobado' => true));

            $fileContent .= "Año" . $CSV . "Referencia_Geográfica" . $CSV . $etiquetasStr . "\r\n";
            $idRefGeograficaActual = $valoresIndicadores[0]->getIdrefgeografica()->getId();
            foreach ($valoresIndicadores as $e) {
                $id = $e->getIdvaloresindicadoresconfigfecha()->getId();
                $idRefGeografica = $e->getIdrefgeografica()->getId();
                $idEtiqueta = $e->getIdetiqueta();
                $valor = str_replace('.', ',', $e->getValor());
                if ($idRefGeografica != $idRefGeograficaActual) {
                    $periodo = $valoresIndicadoresConfigFechaMap[$id];
                    $fileContent .= $periodo . $CSV;
                    $fileContent .= $refGeograficaMap[$idRefGeograficaActual] . $CSV;
                    for ($i = 0; $i < $cardinalEtiquetas ; $i++) { 
                        $fileContent .= $valores[$i] . $CSV;
                        $valores[$i] = 0;
                    }
                    $fileContent .= "\r\n";
                    $idRefGeograficaActual = $idRefGeografica;
                }
                $indice = $etiquetasMap[$idEtiqueta][1];
                $valores[$indice] = $valor;
            }
            $periodo = $valoresIndicadoresConfigFechaMap[$id];
            $fileContent .= $periodo . $CSV;
            $fileContent .= $refGeograficaMap[$idRefGeograficaActual] . $CSV;
            for ($i = 0; $i < $cardinalEtiquetas ; $i++) { 
                $fileContent .= $valores[$i] . $CSV;
            }
            $fileContent .= "\r\n";
        }

        $response = new Response($fileContent);
        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $fileName
        );
        $response->headers->set('Content-Disposition', $disposition);
        return $response;
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

    private function getPeriodo($fechaStr) {
        $parseResult = explode("-", $fechaStr)[0];
        return $parseResult;
    }

    private function parseFechasDestacadas($fechasDestacadasStr) {
        $fechasDestacadas = array();
        if ($fechasDestacadasStr) {
            $parseResult = explode(";", $fechasDestacadasStr);
            foreach ($parseResult as $fecha) {
            array_push($fechasDestacadas, date('Y', strtotime($fecha)));
            }    
        }
        return $fechasDestacadas;
    }

    private function intersectFechasDestacadas($fechasDestacadasIndicador, $fechasDestacadasDefinidas) {
        $interseccion = array();
        foreach ($fechasDestacadasIndicador as $f) {
            /* IMPLEMENTAR BUSQUEDA BINARIA! */
            if (in_array($f, $fechasDestacadasDefinidas)){
                array_push($interseccion, $f);
            }
        }
        return $interseccion;
    }

    private function buildScale($tipo, $minimo, $maximo) {
        $lenght = 5;
        $scale = array();
        $step = floor(($maximo - $minimo) / $lenght);
        $scale[0] = floatval($minimo);
        for ($i = 1; $i < $lenght; $i++) { 
            $scale[$i] = $scale[$i-1] + $step;
        }
        return $scale;
    }

    private function getIndicadoresPreload() {
        $list = array();
        /* Si se desean filtrar los indicadores por meta seleccionada, descomentar y reemplazar  */
        // $indicadores =  $this->getDoctrine()->getRepository('AppBundle:Indicadores')->findByFkidmeta($idMeta);

        $indicadores =  $this->getDoctrine()->getRepository('AppBundle:Indicadores')->findByVisible(true);

        foreach ($indicadores as $i) {
            $idIndicador = $i->getId();
            $list[$idIndicador] = array();
            $list[$idIndicador]['descripcion'] = $i->getDescripcion();
            $list[$idIndicador]['id_meta'] = $i->getFkidmeta()->getId();
            $list[$idIndicador]['ambito'] = $i->getAmbito();
            $list[$idIndicador]['documentoTecnico'] = $i->getDocumentPath();
            $list[$idIndicador]['tipo'] = $i->getTipo();
            $list[$idIndicador]['valMin'] = $i->getValmin();
            $list[$idIndicador]['valMax'] = $i->getValmax();
            // $list[$idIndicador]['escala'] = array(0, 20, 40, 60, 80);
            $list[$idIndicador]['escala'] = $this->buildScale($list[$idIndicador]['tipo'], $list[$idIndicador]['valMin'], $list[$idIndicador]['valMax']);
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

            $etiquetas[$id] = array('descripcion' => $descripcion,
                                    'id_desglose' => $e->getFkiddesgloce()->getId());

            // array_push($etiquetas, array(
            //     'id' => $id,
            //     'descripcion' => $descripcion,
            //     'id_desglose' => $e->getFkiddesgloce()->getId())
            // );
            $maximoID = max($maximoID, $e->getId());

        }

        $desgloses = array_unique($desgloses);

        foreach ($desgloses as $idDesglose) {
            $maximoID += 1;
            /* Se crean nuevas etiquetas con la descripción 'Total' para cada desglose
            Para ello, se comienza desde el ID de etiqueta más alto */
            // array_push($etiquetas, array(
            //     'id' => $maximoID,
            //     'descripcion' => 'Total',
            //     'id_desglose' => $idDesglose)
            // );

            $etiquetas[$maximoID] = array('descripcion' => 'Total',
                                          'id_desglose' => $idDesglose);

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
    /* VERIFICAR QUE FILTRO POR APROBADO FUNCIONE CORRECTAMENTE */

    private function getValoresIndicadoresDesgloses($idIndicador, $reverseDesgloses){
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
        }

        $entidad = $this->filterValoresIndicadoresByIdsSet($idsValoresIndicadoresConfigFecha);
        foreach ($entidad as $e){
            $idValoresIndicadoresConfigFecha = $e->getIdValoresIndicadoresConfigFecha()->getId();
            $idRefGeografica = $e->getIdRefGeografica()->getId();
            $idEtiqueta = $e->getIdEtiqueta();
            $valor = $e->getValor();
            $fecha = $atributos[$idValoresIndicadoresConfigFecha]['fecha'];

            if (!array_key_exists($fecha, $atributosPorFecha)) {
                $atributosPorFecha[$fecha] = array('id_desgloses' => array(),
                'valoresRefGeografica' => array());
            }

            /* Valor es String en la entidad, ¿por qué?*/
            $atributosPorFecha[$fecha]['valoresRefGeografica'][$idRefGeografica][$idEtiqueta] = floatval($valor);            
        }

        $entidad = $this->filterValoresIndicadoresConfigDesglosesFechaByIdsSet($idsValoresIndicadoresConfigFecha);
        foreach ($entidad as $e){
            $idValoresIndicadoresConfigFecha = $e->getIdValoresIndicadoresConfigFecha();
            $idDesglose = $e->getIdDesgloce();
            $fecha = $atributos[$idValoresIndicadoresConfigFecha]['fecha'];
            if (array_key_exists($fecha, $atributosPorFecha)) {
                array_push($atributosPorFecha[$fecha]['id_desgloses'], $idDesglose);    
            }
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

    /* REEMPLAZAR POR FUNCIÓN NATIVA DE SYMFONY */
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
                e.idvaloresindicadoresconfigfecha IN (:idsSet) AND e.aprobado = TRUE'
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
            'SELECT idValoresIndicadoresConfigFecha, idRefGeografica, fkIdDesgloce AS idDesglose, SUM(valor) AS acumulado FROM (SELECT idValoresIndicadoresConfigFecha, idEtiqueta, idRefGeografica, valor FROM valoresIndicadores WHERE idValoresIndicadoresConfigFecha IN (?) AND aprobado = TRUE) AS TLeft INNER JOIN etiquetas as TRight ON TLeft.idEtiqueta = TRight.id GROUP BY idValoresIndicadoresConfigFecha, idRefGeografica, fkIdDesgloce',
            array($idsSet),
            array(\Doctrine\DBAL\Connection::PARAM_INT_ARRAY)
            )->fetchAll();
    }
}
// http://librosweb.es/libro/symfony_2_x/capitulo_8/buscando_objetos.html


