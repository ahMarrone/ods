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
     * @Route(name="explora_initialize")
     */
    public function initializeAction(Request $request)
    {
        /* Recuperar Metas, Objetivos, Indicadores, Desgloses, Etiquetas junto 
        con los correspondientes valores para cada Referencia Geogŕafica de acuerdo
        al indicador seleccionado */

        $objetivos = $this->getObjetivosPreload();
        $metas = $this->getMetasPreload();
        $indicadores = $this->getIndicadoresPreload();

        $idIndicador = json_decode($request->query->get('id'));
        if (isset($idIndicador)) {
            /* Antes de continuar verificar si el Indicador solicitado existe y se encuentra 'visible' */    
            if (!(array_key_exists($idIndicador, $indicadores))) {
                throw $this->createNotFoundException('Indicador Inexistente');        
            }
        } else {
            /* Primer Indicador de la Tabla (Visible) */
            $idIndicador = array_keys($indicadores)[0];
        }
        
        $etiquetas = $this->getEtiquetasByIndicadorPreload($idIndicador);
        $desgloses = $this->getDesglosesByIndicadorPreload($idIndicador);
        $valoresIndicadoresDesgloses = $this->getValoresIndicadoresDesgloses($idIndicador);
        $indicadores[$idIndicador]['fechasDestacadas'] = $this->intersectFechasDestacadas(
            $indicadores[$idIndicador]['fechasDestacadas'], array_keys($valoresIndicadoresDesgloses));

        return $this->render('explora/explora.html.twig', array(
            'objetivos' => $objetivos,
            'metas' => $metas,
            'indicadores' => $indicadores,
            'desgloses' => $desgloses,
            'etiquetas' => $etiquetas,
            'valoresIndicadoresDesgloses' => $valoresIndicadoresDesgloses,
            'idIndicadorSeleccionado' => $idIndicador,
            'api_urls' => array('refresh'=> $this->generateUrl('explora_refresh'),
                                'export'=> $this->generateUrl('export_refresh'))
        ));
    }

    /**
     * Refrescar 'valoresIndicadoresDesgloses' al seleccionar un nuevo 'Indicador'
     * @Route("/api/refresh", name="explora_refresh")
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
            $indicador = $this->getDoctrine()->getRepository('AppBundle:Indicadores')->findOneById($idIndicador);
            $fechasDestacadasIndicador = $this->parseFechasDestacadas($indicador->getFechasDestacadas());
            $callbackData['etiquetas'] = $this->getEtiquetasByIndicadorPreload($idIndicador);
            $callbackData['desgloses'] = $this->getDesglosesByIndicadorPreload($idIndicador);;
            $callbackData['valoresIndicadoresDesgloses'] = $this->getValoresIndicadoresDesgloses($idIndicador);
            $fechasDestacadasDefinidas = array_keys($callbackData['valoresIndicadoresDesgloses']);
            $callbackData['fechasDestacadas'] = $this->intersectFechasDestacadas($fechasDestacadasIndicador, $fechasDestacadasDefinidas);
        } else {
            throw $this->createNotFoundException('Indicador no encontrado');    
        }

        return new JsonResponse($callbackData);
    }

    /**
     * Exportar datos del Indicador
     * @Route("/api/export", name="export_refresh")
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
            $fileContent .= 'Objetivo: ' . $objetivo->getCodigo(). ":" . $objetivo->getDescripcion() . "\r\n";
            $fileContent .= 'Meta: ' . $meta->getFkidobjetivo()->getCodigo() . "." . $meta->getCodigo() . ":" . $meta->getDescripcion() . "\r\n";
            $fileContent .= 'Indicador: ' . $indicador->getFkidmeta()->getFkidobjetivo()->getCodigo() . "." . $indicador->getFkidmeta()->getCodigo() . "." . $indicador->getCodigo() . ":" . $indicador->getDescripcion() . "\r\n";
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
            
            // echo var_dump($valoresIndicadoresConfigFechaMap);
            // echo var_dump($idsValoresIndicadoresConfigFecha);

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
            if ($ambito == 'D') {
                $fileContent .= "Año" . $CSV . "Provincia" . $CSV . "Referencia_Geográfica" . $CSV . $etiquetasStr . "\r\n";
                $provincias = $this->getDoctrine()->getRepository('AppBundle:Refgeografica')->findByAmbito('P');
                $provinciasMap = array();
                foreach ($provincias as $e) {
                    $id = $e->getId();
                    $descripcion = $e->getDescripcion();
                    $provinciasMap[$id] = $descripcion;
                }
                $idsRefGeografica = array_keys($refGeograficaMap);
                $agrupamientoRefGeografica = $this->getDoctrine()->getRepository('AppBundle:Agrupamientorefgeografica')->findById1($idsRefGeografica);
                $agrupamientoRefGeograficaMap = array();
                foreach ($agrupamientoRefGeografica as $e) {
                    $idDepartamento = $e->getId1();
                    $idProvincia = $e->getId2();
                    $agrupamientoRefGeograficaMap[$idDepartamento] = $provinciasMap[$idProvincia];
                }
            } else {
                $fileContent .= "Año" . $CSV . "Referencia_Geográfica" . $CSV . $etiquetasStr . "\r\n";    
            }
            
            // echo var_dump($idsValoresIndicadoresConfigFecha);

            /* ORDENAR POR ID, IDREFGEO */
            $valoresIndicadores = $this->getDoctrine()->getRepository('AppBundle:Valoresindicadores')->findBy(
                array('idvaloresindicadoresconfigfecha' => $idsValoresIndicadoresConfigFecha));

            
            $idRefGeograficaActual = $valoresIndicadores[0]->getIdrefgeografica()->getId();
            $idValoresIndicadoresConfigFechaActual = $valoresIndicadores[0]->getIdvaloresindicadoresconfigfecha()->getId();
            foreach ($valoresIndicadores as $e) {
                $id = $e->getIdvaloresindicadoresconfigfecha()->getId();
                $idRefGeografica = $e->getIdrefgeografica()->getId();
                $idEtiqueta = $e->getIdetiqueta();
                $valor = str_replace('.', ',', $e->getValor());
                // echo var_dump($idRefGeografica);
                // echo var_dump($idRefGeograficaActual);
                if (($idRefGeografica != $idRefGeograficaActual) || ($id != $idValoresIndicadoresConfigFechaActual)) {
                    $periodo = $valoresIndicadoresConfigFechaMap[$idValoresIndicadoresConfigFechaActual];
                    $fileContent .= $periodo . $CSV;
                    if ($ambito == 'D') {
                        $fileContent .= $agrupamientoRefGeograficaMap[$idRefGeograficaActual] . $CSV;
                    }
                    $fileContent .= $refGeograficaMap[$idRefGeograficaActual] . $CSV;
                    for ($i = 0; $i < $cardinalEtiquetas ; $i++) { 
                        $fileContent .= $valores[$i] . $CSV;
                        $valores[$i] = 0;
                    }
                    $fileContent .= "\r\n";
                    $idRefGeograficaActual = $idRefGeografica;
                    $idValoresIndicadoresConfigFechaActual = $id;
                }
                $indice = $etiquetasMap[$idEtiqueta][1];
                $valores[$indice] = $valor;
            }
            $periodo = $valoresIndicadoresConfigFechaMap[$id];
            $fileContent .= $periodo . $CSV;
            if ($ambito == 'D') {
                $fileContent .= $agrupamientoRefGeograficaMap[$idRefGeograficaActual] . $CSV;
            }
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

    private function getObjetivosPreload(){
        $list = array();
        $objetivos =  $this->getDoctrine()->getRepository('AppBundle:Objetivos')->findAll();
        foreach ($objetivos as $o) {
            $id = $o->getId();
            $list[$id] = array('codigo'=>$o->getCodigo(),
                               'descripcion'=>$o->getDescripcion());
        }
        return $list;
    }

    private function getMetasPreload(){
        $list = array();
        $metas =  $this->getDoctrine()->getRepository('AppBundle:Metas')->findAll();
        foreach ($metas as $m) {
            $id = $m->getId();
            $list[$id] = array('codigo'=>$m->getFkidobjetivo()->getCodigo() . "." . $m->getCodigo(),
                               'descripcion'=>$m->getDescripcion(),
                               'id_objetivo'=>$m->getFkidobjetivo()->getId());
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
            $list[$idIndicador]['codigo'] = $i->getFkidmeta()->getFkidobjetivo()->getCodigo() . "." . $i->getFkidmeta()->getCodigo() . "." . $i->getCodigo();
            $list[$idIndicador]['descripcion'] = $i->getDescripcion();
            $list[$idIndicador]['id_meta'] = $i->getFkidmeta()->getId();
            $list[$idIndicador]['ambito'] = $i->getAmbito();
            $list[$idIndicador]['documentoTecnico'] = $i->getDocumentPath();
            $list[$idIndicador]['tipo'] = $i->getTipo();
            $list[$idIndicador]['valMin'] = $i->getValmin();
            $list[$idIndicador]['valMax'] = $i->getValmax();
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

    private function getEtiquetasByIndicadorPreload($idIndicador){
        $etiquetasEntity = $this->filterEtiquetasByIndicador($idIndicador);
        $etiquetas = array('foo' => NULL);
        foreach ($etiquetasEntity as $e){
            $id = $e->getId();
            $descripcion = $e->getDescripcion();        
            $etiquetas[$id] = array('descripcion' => $descripcion,
                                    'id_desglose' => $e->getFkiddesgloce()->getId());
        }
        return $etiquetas;
    }

    private function getDesglosesByIndicadorPreload($idIndicador){
        $desglosesEntity = $this->filterDesglosesByIndicador($idIndicador);
        $desgloses = array('foo' => NULL);
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


