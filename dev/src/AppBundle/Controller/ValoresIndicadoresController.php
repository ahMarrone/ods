<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Valoresindicadores;
use AppBundle\Entity\Valoresindicadoresconfigfecha;
use AppBundle\Entity\Valoresindicadoresconfigfechadesgloces;
use AppBundle\Entity\Indicadores;
use AppBundle\Entity\Etiquetas;
use AppBundle\Entity\Refgeografica;
use AppBundle\Form\ValoresIndicadoresType;
use AppBundle\Type\CustomDateTimeType;

/**
 * ValoresIndicadores controller.
 *
 * @Route("/admin/crud/valoresindicadores")
 */
class ValoresIndicadoresController extends Controller
{
    /**
     * Lists all ValoresIndicadores entities.
     *
     * @Route("/{id_indicador}",  requirements={"id_indicador" = "\d+"}, name="admin_crud_valoresindicadores_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', $this->getUser(), 'No tiene permisos para ingresar a esta página!');
        $etiquetas = $valoresindicadores = NULL;
        $indicadorDesc = "";
        $idIndicador = intval($request->get('id_indicador'));
        $em = $this->getDoctrine()->getManager();
        $indicador = $em->getRepository('AppBundle:Indicadores')->findOneById($idIndicador);
        if (count($indicador)){
            $indicadorDesc = $indicador->getDescripcion();
            $configfechaEntity = $em->getRepository('AppBundle:Valoresindicadoresconfigfecha')->findByIdindicador($idIndicador);
            $valoresindicadores = $em->getRepository('AppBundle:Valoresindicadores')->findByIdvaloresindicadoresconfigfecha($configfechaEntity);
            $etiquetas = $this->getKeyValueEtiquetas($em->getRepository('AppBundle:Etiquetas')->findAll());
            return $this->render('valoresindicadores/index.html.twig', array(
                'valoresindicadores' => $valoresindicadores,
                'etiquetas'=> $etiquetas,
                'indicador' => $indicador,
                'api_urls' => array('aproveData'=> $this->generateUrl('admin_crud_valoresindicadores_aproveData'))
            ));
        } else {
            return $this->redirectToRoute('paneluser_index');
        }
    }


    /**
     * Ver valoresindicadores formato reporting
     *
     * @Route("/visualize", name="admin_crud_valoresindicadores_visualize")
     * @Route("/visualize/{id_indicador}", requirements={"id_indicador":"\d+"}, name="admin_crud_valoresindicadores_visualize_id_indicador", defaults={"id_indicador" = -1})
     * @Route("/visualize/{id_indicador}/{date}", requirements={"id_indicador":"\d+", "date":"\d{4}"}, name="admin_crud_valoresindicadores_visualize_id_indicador_date", defaults={"id_indicador" = -1, "date" = -1})
     * @Method("GET")
     */
    public function visualizeAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', $this->getUser(), 'No tiene permisos para ingresar a esta página!');
        $id_indicador_selected = $id_meta_selected = $id_objetivo_selected = -1;
        $id_indicador = $request->get('id_indicador');
        $preselectedDate = $request->get('date');
        if (!$preselectedDate){
            $preselectedDate = "0";
        }
        if ($id_indicador && $id_indicador > 0){
            $indicador = $this->getDoctrine()->getRepository('AppBundle:Indicadores')->findOneById($id_indicador);
            if ($indicador){
                $id_indicador_selected = $id_indicador;
                $id_meta_selected = $indicador->getFkidmeta()->getId();
                $id_objetivo_selected = $indicador->getFkidmeta()->getFkidobjetivo()->getId();
            }
        }
        $date = $request->get('date');
        $em = $this->getDoctrine()->getManager();
        list($objetivos, $metas, $indicadores) = $this->preparePreloadData();
        if (count($metas) && count($indicadores)){
            $valoresindicadores = $em->getRepository('AppBundle:Valoresindicadores')->findAll();
            return $this->render('valoresindicadores/visualize.html.twig', array(
                'objetivos'=>$objetivos,
                'metas'=>$metas,
                'indicadores'=>$indicadores,
                'valoresindicadores' => $valoresindicadores,
                'id_objetivo_selected' => $id_objetivo_selected,
                'id_meta_selected' => $id_meta_selected,
                'id_indicador_selected' => $id_indicador_selected,
                'preselected_date' => $preselectedDate,
                'api_urls' => array(
                    'indicador_dates'=> $this->generateUrl('admin_crud_valoresindicadores_indicador_dates'),
                )
            ));
        } else {
            $request->getSession()
                ->getFlashBag()
            ->add('warning', "Por favor, verifique que existan al menos una Meta y un Indicador cargados en el sistema");
            return $this->redirectToRoute('paneluser_index'); 
        }
    }


    /**
     * Ver valoresindicadores formato reporting
     *
     * @Route("/visualize/data/getdata", name="admin_crud_valoresindicadores_visualize_getdata")
     * @Method("GET")
     */
    public function getVisualizeData(Request $request){
        $id_indicador = $fecha = null;
        $response = array("data"=>array());
        $get_params = $request->query->all();
        if (isset($get_params["id_indicador"])){
            $id_indicador = intval($get_params["id_indicador"]);
        };
        if (isset($get_params["fecha"])){
            $fecha = $get_params["fecha"];
        };
        if ($id_indicador != null && $fecha != null){
            $response["data"] = $this->requestVisualizeData($id_indicador, $this->formatDateToDB($fecha));
            //$response["data"] = array(array(3),array(4),array(5)); 
        }
        return new JsonResponse($response);
    }


    private function requestVisualizeData($idIndicador, $fecha){
        $data = array();
        $em = $this->getDoctrine()->getManager();
        $indicador = $this->getDoctrine()->getRepository('AppBundle:Indicadores')->findOneById($idIndicador);
        if ($indicador){
            $ambitoIndicador = $indicador->getAmbito();
            $configfechaEntity = $em->getRepository('AppBundle:Valoresindicadoresconfigfecha')->findBy(array(
                'idindicador' => $idIndicador,
                'fecha' => $fecha
            ));
            $valoresindicadores = $em->getRepository('AppBundle:Valoresindicadores')->findByIdvaloresindicadoresconfigfecha($configfechaEntity);
            $regGeograficasWithoutData = $this->filterRefGeograficas($indicador->getAmbito());
            $regGeograficasWithoutData = $this->initRefGeograficasUsedEtiquetas($regGeograficasWithoutData);
            $mapEtiquetas = $this->getKeyValueEtiquetas($em->getRepository('AppBundle:Etiquetas')->findAll());
            $usedEtiquetas = array();
            $refGeogMemoize = array();
            $indicadorEtiquetas = array();
            // PIDO DATOS EXISTENTES
            foreach ($valoresindicadores as $valor) {
                // achico universo de refgeograficas con datos sin cargar
                //unset($regGeograficasWithoutData[$valor->getIdrefgeografica()->getId()]);
                //echo var_dump($valor->getIdetiqueta());
                array_push($regGeograficasWithoutData[$valor->getIdrefgeografica()->getId()]["used_labels"], $valor->getIdetiqueta());
                if ($ambitoIndicador == 'N'){
                    $parent = "-";
                } else if ($ambitoIndicador == 'P') {
                    $parent = 'PAIS';
                } else {
                    $refParent = $this->getAgrupamientoRefGeografica($valor->getIdrefgeografica()->getId());
                    $parent = $this->getDoctrine()->getRepository('AppBundle:Refgeografica')->findOneById($refParent->getId2())->getDescripcion();
                }
                $newEtiquetaLabel = $this->mapEtiquetaKeyToString($mapEtiquetas,$valor->getIdetiqueta());
                $usedEtiquetas[$valor->getIdetiqueta()] = $newEtiquetaLabel;
                $aprobado = $valor->getAprobado() ? "Si" : "No";
                $tmp_data = $this->bindDataToVisualize(
                    $valor->getIdrefgeografica()->getDescripcion(), 
                    $parent,
                    $newEtiquetaLabel,
                    $valor->getValor(),
                    $aprobado
                );
                array_push($data, $tmp_data);
            }
            //echo var_dump($regGeograficasWithoutData);
            // INSERTO DATOS FALTANTES
            //  (ref. geog en los cuales no se han cargado datos)
            foreach ($usedEtiquetas as $idEtiqueta => $descEtiqueta) {
                foreach ($regGeograficasWithoutData as $key => $refData) {
                    if (!in_array($idEtiqueta, $refData["used_labels"])){
                        $parent = $this->getDoctrine()->getRepository('AppBundle:Refgeografica')->findOneById($refData["parent"])->getDescripcion();
                        $tmp_data = $this->bindDataToVisualize(
                            $refData["desc"], 
                            $parent,
                            $descEtiqueta,
                            "SIN VALOR",
                            "-"
                        );
                        array_push($data, $tmp_data);
                    }
                }
            }
            /*foreach ($regGeograficasWithoutData as $key => $refData) {
                foreach ($usedEtiquetas as $idEtiqueta => $descEtiqueta) {
                    $parent = $this->getDoctrine()->getRepository('AppBundle:Refgeografica')->findOneById($refData["parent"])->getDescripcion();
                    $tmp_data = $this->bindDataToVisualize(
                        $refData["desc"], 
                        $parent,
                        $descEtiqueta,
                        "SIN VALOR",
                        "-"
                    );
                    array_push($data, $tmp_data);
                }
            }*/

        }
        return $data;
    }


    private function initRefGeograficasUsedEtiquetas($refs){
        foreach ($refs as $key => $refData) {
            $refs[$key]["used_labels"] = array();
        }
        //echo var_dump($refs[$key]["used_labels"]);
        return $refs;
    }


    /*private function requestVisualizeData($idIndicador, $fecha){
        $data = array();
        $em = $this->getDoctrine()->getManager();
        $indicador = $this->getDoctrine()->getRepository('AppBundle:Indicadores')->findOneById($idIndicador);
        if ($indicador){
            $ambitoIndicador = $indicador->getAmbito();
            $configfechaEntity = $em->getRepository('AppBundle:Valoresindicadoresconfigfecha')->findBy(array(
                'idindicador' => $idIndicador,
                'fecha' => $fecha
            ));
            $valoresindicadores = $em->getRepository('AppBundle:Valoresindicadores')->findByIdvaloresindicadoresconfigfecha($configfechaEntity);
            $regGeograficasWithoutData = $this->filterRefGeograficas($indicador->getAmbito());
            //echo var_dump($regGeograficasWithoutData);
            $mapEtiquetas = $this->getKeyValueEtiquetas($em->getRepository('AppBundle:Etiquetas')->findAll());
            $usedEtiquetas = array();
            $refGeogMemoize = array();
            $indicadorEtiquetas = array();
            // PIDO DATOS EXISTENTES
            foreach ($valoresindicadores as $valor) {
                // achico universo de refgeograficas con datos sin cargar
                unset($regGeograficasWithoutData[$valor->getIdrefgeografica()->getId()]);
                if ($ambitoIndicador == 'N'){
                    $parent = "-";
                } else if ($ambitoIndicador == 'P') {
                    $parent = 'PAIS';
                } else {
                    $refParent = $this->getAgrupamientoRefGeografica($valor->getIdrefgeografica()->getId());
                    $parent = $this->getDoctrine()->getRepository('AppBundle:Refgeografica')->findOneById($refParent->getId2())->getDescripcion();
                }
                $newEtiquetaLabel = $this->mapEtiquetaKeyToString($mapEtiquetas,$valor->getIdetiqueta());
                $usedEtiquetas[$valor->getIdetiqueta()] = $newEtiquetaLabel;
                $aprobado = $valor->getAprobado() ? "Si" : "No";
                $tmp_data = $this->bindDataToVisualize(
                    $valor->getIdrefgeografica()->getDescripcion(), 
                    $parent,
                    $newEtiquetaLabel,
                    $valor->getValor(),
                    $aprobado
                );
                array_push($data, $tmp_data);
            }
            // INSERTO DATOS FALTANTES
            //  (ref. geog en los cuales no se han cargado datos)
            foreach ($regGeograficasWithoutData as $key => $refData) {
                foreach ($usedEtiquetas as $idEtiqueta => $descEtiqueta) {
                    $parent = $this->getDoctrine()->getRepository('AppBundle:Refgeografica')->findOneById($refData["parent"])->getDescripcion();
                    $tmp_data = $this->bindDataToVisualize(
                        $refData["desc"], 
                        $parent,
                        $descEtiqueta,
                        "SIN VALOR",
                        "-"
                    );
                    array_push($data, $tmp_data);
                }
            }

        }
        return $data;
    }*/

    private function bindDataToVisualize($refDesc, $parent, $descEtiqueta, $value, $aprobado){
        $bindedData = array();
        array_push($bindedData, $refDesc);
        array_push($bindedData, $parent);
        array_push($bindedData, $descEtiqueta);
        array_push($bindedData, $value);
        array_push($bindedData, $aprobado);
        return $bindedData;
    }



    /**
     * Crea/Actualiza instancias de ValoresIndicadores.
     *
     * @Route("/new", name="admin_crud_valoresindicadores_new")
     * @Method({"POST"})
     */
    public function newAction(Request $request)
    {
        $params = $this->getRequest()->request->all();
        $idIndicador = (isset($params["id_indicador_selected"])) ? $params["id_indicador_selected"] : NULL;
        $plain_fecha =  (isset($params["fecha"])) ? $params["fecha"] : NULL;
        $fecha = $this->formatDateToDB($plain_fecha);
        $configfecha = $this->getIndicadorConfigByKey($idIndicador, $fecha);
        
        if ($configfecha){
            $indicador = $this->getDoctrine()->getRepository('AppBundle:Indicadores')->findById($idIndicador)[0];
            //$indicadorDesgloces = $this->getDoctrine()->getRepository('AppBundle:Desglocesindicadores')->findByIdindicador($idIndicador);
            $userDesgloces = $this->getDoctrine()->getRepository('AppBundle:Valoresindicadoresconfigfechadesgloces')->findByIdvaloresindicadoresconfigfecha($configfecha->getId());
            $cruzado = $configfecha->getCruzado();
            list($desgloces, $etiquetasDesgloces) = $this->getEtiquetasDesgloce($userDesgloces);
            //echo var_dump($desgloces);
            $refGeograficas = $this->filterRefGeograficas($indicador->getAmbito());
            $valoresindicadores = $this->getDoctrine()->getRepository('AppBundle:Valoresindicadores')
                               ->filterByIndicadorFecha($idIndicador, $fecha);
            $valoresindicadores = $this->parseEntityValoresindicadores($valoresindicadores);
            $ambitoIndicador = $indicador->getAmbito();
            $step = ($indicador->getTipo() == 'entero') ? "1" : "0.01";
            $is_fecha_hito = $indicador->isFechaHito($fecha);
            return $this->render('valoresindicadores/panel_create_valores_indicadores.html.twig', array(
                'fecha' => $fecha,
                'is_fecha_hito' => $is_fecha_hito,
                'indicador_id' => $indicador->getId(),
                'indicador' => $indicador,
                'indicador_ambito' => $ambitoIndicador,
                'desgloces' => $desgloces,
                'etiquetas_desgloces' => $etiquetasDesgloces,
                'cruzado' => $cruzado,
                'ref_geograficas' => $refGeograficas,
                'filter_ref_geograficas' => $this->getParentRefGeograficas($ambitoIndicador),
                'valores_indicadores' => $valoresindicadores,
                'value_type' => $indicador->getTipo(),
                'step' => $step,
                'range_min' => $indicador->getValmin(),
                'range_max'=> $indicador->getValmax(),
                'api_urls' => array('edit'=> $this->generateUrl('admin_crud_valoresindicadores_saveobjects'), 
                                    'delete'=> $this->generateUrl('admin_crud_valoresindicadores_deleteobjects')
                )
        ));
        } else {
			//echo var_dump($this->getRequest()->request->all());
			return $this->redirectToRoute('admin_crud_valoresindicadores_preload'); 
        }
    }
    // Retorna lista de ref. geograficas que actuan como filtro de otras.
    // EJ: La lista de provincias actuan como filtro para las departamentales
    private function getParentRefGeograficas($ambitoIndicador){
        $filters = array();
        $ambitoPivot = null;
        if ($ambitoIndicador = 'D'){
            $ambitoPivot = 'P';
        }
        if ($ambitoPivot != null){
            $refs = $this->getDoctrine()->getRepository('AppBundle:Refgeografica')->findBy(
                array('ambito' => 'P'));
        }
        foreach ($refs as $ref) {
            array_push($filters, array('id'=>$ref->getId(), 'name'=>$ref->getDescripcion()));
        }
        return $filters;
    }

    private function parseEntityValoresindicadores($valoresindicadores){
        $ret = array();
        foreach ($valoresindicadores as $vi){
            $data = array(
                'id_etiqueta' => $vi->getIdetiqueta(),
                'id_ref_geografica' => $vi->getIdrefgeografica()->getId(),
                'user' => $vi->getIdUsuario()->getUsernameCanonical(),
                'dateModif' => $vi->getFechamodificacion(),
                'valor' => $vi->getValor(),
            );
            array_push($ret, $data);
        }
        return $ret;
    }


    /**
     * PRELOAD ValoresIndicadores entity.
     *
     * @Route("/preload", name="admin_crud_valoresindicadores_preload")
     * @Route("/preload/{id_indicador}", name="admin_crud_valoresindicadores_preload_indicador")
     * @Method({"GET"})
     */
    public function preloadAction(Request $request){
        list($objetivos, $metas, $indicadores) = $this->preparePreloadData();
        if (count($metas) && count($indicadores)){
            //$id_objetivo_selected = $objetivos[0]["id"];
            //$id_meta_selected = $metas[0]["id"];
            //$id_indicador_selected = $indicadores[0]["id"];
            $user_indicador_selected = intval($request->get('id_indicador'));
            if ($user_indicador_selected){
                $indicador = $this->getDoctrine()->getRepository('AppBundle:Indicadores')->findOneById($user_indicador_selected);
                if ($indicador){
                    $id_indicador_selected = $indicador->getId();
                    $id_meta_selected = $indicador->getFkidmeta()->getId();
                    $id_objetivo_selected = $indicador->getFkidmeta()->getFkidobjetivo()->getId();
                }
            }
            return $this->render('valoresindicadores/preload.html.twig', array(
                'objetivos'=>$objetivos,
                'metas'=>$metas,
                'indicadores'=>$indicadores,
                'id_indicador_selected' => -1,
                'id_meta_selected' => -1,
                'id_objetivo_selected' => -1,
                'api_urls' => array(
                    'indicador_dates'=> $this->generateUrl('admin_crud_valoresindicadores_indicador_dates'),
                    'indicador_desgloces_config' => $this->generateUrl('admin_crud_valoresindicadores_indicador_desgloces_config'),
                    'save_desgloces_config' => $this->generateUrl('admin_crud_valoresindicadores_indicador_save_desgloces_config')
                )
            ));
        } else {
            $request->getSession()
                ->getFlashBag()
                ->add('warning', "Por favor, verifique que existan al menos una Meta y un Indicador cargados en el sistema");
            return $this->redirectToRoute('paneluser_index'); 
        }
    }

    // Retorna lista de objetivos, metas e indicadores. Relacionados mediante sus id's. (Mejorar)
    private function preparePreloadData(){
        $objetivosList = $this->getObjetivosPreload();
        $metasList = $this->getMetasPreload();
        $indicadoresList = $this->getIndicadoresPreload();
        return array($objetivosList,$metasList,$indicadoresList);
    }

    private function getObjetivosPreload(){
        $list = array();
        $objetivos =  $this->getDoctrine()->getRepository('AppBundle:Objetivos')->findAll();
        foreach ($objetivos as $o) {
            array_push($list, array('id'=>$o->getId(),'desc'=>$o->getDescripcion(),'code'=>$o->getCodigo()));
        }
        return $list;
    }

    private function getMetasPreload(){
        $list = array();
        $metas =  $this->getDoctrine()->getRepository('AppBundle:Metas')->findAll();
        foreach ($metas as $m) {
            array_push($list, array('id'=>$m->getId(),'desc'=>$m->getDescripcion(),'id_objetivo'=>$m->getFkidobjetivo()->getId(), 'code'=>$m->getCodigo(), 'code_objetivo'=>$m->getFkidobjetivo()->getCodigo()));
        }
        return $list;
    }

    private function getIndicadoresPreload(){
        $list = array();
        $indicadores =  $this->getDoctrine()->getRepository('AppBundle:Indicadores')->findAll();
        foreach ($indicadores as $i) {
            array_push($list, array('id'=>$i->getId(),'desc'=>$i->getDescripcion(), 'code'=>$i->getCodigo(), 'code_meta'=>$i->getFkidmeta()->getCodigo(),'code_objetivo'=>$i->getFkidmeta()->getFkidobjetivo()->getId() , 'id_meta'=>$i->getFkidmeta()->getId()));
        }
        return $list;
        
    }

    /**
     * PRELOAD ValoresIndicadores entity.
     *
     * @Route("/saveobjects", name="admin_crud_valoresindicadores_saveobjects")
     * @Method({"POST"})
     */
    public function saveObjectsAction(){
        $content = $this->get("request")->getContent();
        if (!empty($content)){
            $data = json_decode($content, true); // 2nd param to get as array
            $response = $this->initSaveObjects($data);
            return new JsonResponse($response);
        }
    }

    // Realiza transaccion para guardar/actualizar las tuplas
    // en la tabla valoresindicadores
    private function initSaveObjects($data){
        $userLogued = $this->getUser();
        $idIndicador = $data["id_indicador"];
        $fecha = $data["fecha"];
        $indicador = $this->getDoctrine()->getRepository('AppBundle:Indicadores')->findOneById($idIndicador);
        $etiquetasMemoization = array();
        $objects = $data["objects"];
        $em = $this->getDoctrine()->getManager();
        $response = array("success"=>false);
        $configfecha = $this->getIndicadorConfigByKey($idIndicador, $fecha);
        if ($configfecha){
                try {
                    $em->getConnection()->beginTransaction();
                    $fechaModif = date_format(new \DateTime(), 'Y-m-d H:i:s');
                    foreach ($objects as $refId => $refGeograficaObjects){
                        $refgeografica = $this->getDoctrine()->getRepository('AppBundle:Refgeografica')->findOneById($refId);
                        foreach ($refGeograficaObjects as $valorIndicadorData) { 
                            $vi = new Valoresindicadores();
                            $vi->setIdvaloresindicadoresconfigfecha($configfecha);
                            $vi->setIdusuario($userLogued);
                            $vi->setValor($valorIndicadorData["value"]);
                            $vi->setIdEtiqueta($valorIndicadorData["id_etiqueta"]);
                            $vi->setIdrefgeografica($refgeografica);
                            $vi->setAprobado(false);
                            //$vi->setIdindicador($indicador);
                            //$date = new \DateTime($fecha);
                            //$vi->setFecha(date_format($date, 'Y-m-d'));
                            $vi->setFechamodificacion($fechaModif);
                            $em->merge($vi); // persisto valorindicador
                        }
                    }
                    $em->flush();
                    $em->getConnection()->commit();
                    $response["success"] = true;
                    $response["user"] = $userLogued->getUsernameCanonical();
                    $response["dateModif"] = $fechaModif;
                } catch (\Exception $e) {
                    $em->getConnection()->rollback();
                    $response["success"] = false;
                    $response["msg"] = "Ha ocurrido un error mientras se intentaban dar de alta los valores indicadores";
                    $response["exception"] = $e;
                    throw $e;
                }
        }
        return $response;
    }

    /*
    private function memoizeEtiquetas(&$list, $id){
        if (!array_key_exists($id, $list)){
            $list[$id] = $this->getDoctrine()->getRepository('AppBundle:Etiquetas')->findOneById($id);
        }
        return $list[$id];
    }*/

    // Retorna ref. geograficas
    // Filtra de acuerdo a:
    //      - Ambito de indicador
    //      - Ambito de usuario (falta)
    private function filterRefGeograficas($ambitoIndicador){
        $ret = array();
        $refs =  $this->getDoctrine()->getRepository('AppBundle:Refgeografica')->findBy(
             array('ambito' => $ambitoIndicador), array('descripcion' => 'ASC'));
        $parent = 0;
        foreach ($refs as $r) {
            if ($ambitoIndicador == 'D'){
                /*$agrupamiento = $this->getDoctrine()->getRepository('AppBundle:Agrupamientorefgeografica')->findBy(
             array('id_1' => $r->getId()));
                $parent = $agrupamiento[0]->getId2();*/
                $parent = $this->getAgrupamientoRefGeografica($r->getId());
                $parent = $parent->getId2();
            }
            //echo var_dump($parent);
            $ret[$r->getId()] = array('desc'=>$r->getDescripcion(),'used'=>false,'parent'=>$parent);
        }
        return $ret;
    }


    private function getAgrupamientoRefGeografica($idRefChild){
        $agrupamiento = $this->getDoctrine()->getRepository('AppBundle:Agrupamientorefgeografica')->findBy(
             array('id1' => $idRefChild));
        if ($agrupamiento){
         return $agrupamiento[0];
        }
        return null;
    }

    // 
    private function getEtiquetasDesgloce($desglocesIndicador){
        $desgloces = array();
        $etiquetasDesgloce = array();
        foreach ($desglocesIndicador as $desgloceIndicador) {
            $desgloce = $this->getDoctrine()->getRepository('AppBundle:Desgloces')->findOneById($desgloceIndicador->getIddesgloce());
            $etiquetas =  $this->getDoctrine()->getRepository('AppBundle:Etiquetas')->findByFkiddesgloce($desgloce);
            $desgloces[$desgloce->getId()] = $desgloce->getDescripcion();
            $tmpEtiquetas = array();
            foreach ($etiquetas as $e) {
                array_push($tmpEtiquetas, array("id_etiqueta"=>$e->getId(), "desc"=>$e->getDescripcion()));
            }
            $etiquetasDesgloce[$desgloce->getId()] = $tmpEtiquetas;
        }
        return array($desgloces, $etiquetasDesgloce);
    }

    /**
     * Elimina instancias de ValoresIndicadores
     *
     * @Route("/deleteobjects", name="admin_crud_valoresindicadores_deleteobjects")
     * @Method("POST")
     */
    public function deleteObjectsAction(Request $request){
        $content = $this->get("request")->getContent();
        if (!empty($content)){
            $delete_data = json_decode($content, true); // 2nd param to get as array
            $response = $this->initDeleteObjects($delete_data);
            return new JsonResponse($response);
        }
    }

    // inicia delete de valores indicadores
    // Los datos vienen en una lista. Cada elemento tiene asociado una
    // id_ref_geografica. Se eliminan todas los valoresindicadores de esa referencia
    private function initDeleteObjects($data){
        $response = array("success"=>false);
        $idIndicador = $data["id_indicador"];
        $fecha = $data["fecha"];
        $configfecha = $this->getIndicadorConfigByKey($idIndicador, $fecha);
        //$indicador = $this->getDoctrine()->getRepository('AppBundle:Indicadores')->findOneById($idIndicador);
        $objects = $data["objects"];
        $refGeografica = null;
        $em = $this->getDoctrine()->getManager();
        if ($configfecha){
            try {
                $em->getConnection()->beginTransaction();
                // elimino todas las tuplas de ese, indicador, para esa fecha (id de configuracion) y de esa ref_geografica
                foreach ($objects as $refGeograficaID){  
                    $valoresindicadores = $this->getDoctrine()->getRepository('AppBundle:Valoresindicadores')
                                        ->findBy(array('idvaloresindicadoresconfigfecha' => $configfecha->getId(), 'idrefgeografica' => $refGeograficaID));
                    foreach ($valoresindicadores as $valorindicador) {
                        $em->remove($valorindicador);
                    }
                }
                $em->flush();
                $em->getConnection()->commit();
                $response["success"] = true;
            } catch (\Exception $e) {
                $em->getConnection()->rollback();
                $response["success"] = false;
                $response["msg"] = "No se han podido eliminar los objetos";
                $response["exception"] = $e;
                throw $e;
            }
        }
        return $response;
    }



    /**
     * Atiende peticiones para aprobar/desaprobar datos
     *
     * @Route("/aproveData", name="admin_crud_valoresindicadores_aproveData")
     * @Method({"POST"})
     */
    public function aproveDataAction(Request $request){
        $this->denyAccessUnlessGranted('ROLE_ADMIN', $this->getUser(), 'No tiene permisos para ingresar a esta página!');
        $content = $this->get("request")->getContent();
        if (!empty($content)){
            $data = json_decode($content, true); 
            $response = $this->initAproveData($data["data"],$data["action"]);
            return new JsonResponse($response);
        }
    }


    private function initAproveData($data, $aproveAction){
        $em = $this->getDoctrine()->getManager();
        $response = array("success"=>false);
        try {
            $em->getConnection()->beginTransaction();
            foreach ($data as $valorIndicador){
                $fecha = $this->formatDateToDB($valorIndicador["fecha"]);
                $configfecha = $this->getIndicadorConfigByKey($valorIndicador["indicador"], $fecha);
                $valoresindicadores = $this->getDoctrine()->getRepository('AppBundle:Valoresindicadores')
                                    ->findOneBy(array('idvaloresindicadoresconfigfecha'=>$configfecha->getId(),
                                                       'idetiqueta'=>$valorIndicador["etiqueta"],
                                                       'idrefgeografica'=>$valorIndicador["refGeografica"],
                                                )
                                    );
                $valoresindicadores->setAprobado($aproveAction);
            }
            $em->flush();
            $em->getConnection()->commit();
            $response["success"] = true;
            $response["msg"] = "Cambios aplicados con éxito";
        } catch (\Exception $e) {
            $em->getConnection()->rollback();
            $response["success"] = false;
            $response["msg"] = "Ha ocurrido un error mientras se intentaban dar de alta los valores indicadores";
            $response["exception"] = $e;
            throw $e;
        }
        return $response;
    }


    /**
     * Retorna json con las fechas (únicas) en los que el indicador tiene datos cargados
     *
     * @Route("/indicador_dates", name="admin_crud_valoresindicadores_indicador_dates")
     * @Method({"GET"})
     */
    public function getIndicadorDatesAction(Request $request){
        $data = array();
        $idIndicador = $request->query->get('id_indicador');
        if (isset($idIndicador)){
            $rows = $this->getDoctrine()->getRepository('AppBundle:Valoresindicadores')
                               ->getIndicadorDates($idIndicador);

            foreach ($rows as $dates) {
                $newDate = explode("-",$dates["fecha"])[0];
                array_push($data, $newDate);
            }
        }
        return new JsonResponse($data);
    }


    /**
     * Retorna json con las fechas (únicas) en los que el indicador tiene datos cargados
     *
     * @Route("/indicador_desgloces_config", name="admin_crud_valoresindicadores_indicador_desgloces_config")
     * @Method({"GET","POST"})
     */
    public function getIndicadorDesglocesConfig(Request $request){
        $em = $this->getDoctrine()->getManager();
        $id_indicador = $request->query->get('id_indicador');
        $fecha = $request->query->get('fecha');
        $fecha = $this->formatDateToDB($fecha);
        $data = array();
        $userDesgloces = array();
        $configfecha = $this->getIndicadorConfigByKey($id_indicador, $fecha);
        if ($configfecha){
            $data["has_saved_config"] = true;
            $data["desgloces_cross"] = $configfecha->getCruzado();
            $userDesgloces = $this->flatUserDesgloces($this->getDoctrine()->getRepository('AppBundle:Valoresindicadoresconfigfechadesgloces')->findByIdvaloresindicadoresconfigfecha($configfecha->getId()));
        } else {
            $data["has_saved_config"] = false;
            $data["desgloces_cross"] = false;
        }
        $adminDesgloces = $this->getDoctrine()->getRepository('AppBundle:Desglocesindicadores')->findByIdindicador($id_indicador);
        list($desgloces, $etiquetasDesgloces) = $this->getEtiquetasDesgloce($adminDesgloces);
        $data['desgloces_enabled'] = $this->constructDesglocesConfig($adminDesgloces, $userDesgloces, $desgloces, $etiquetasDesgloces);
        return new JsonResponse($data);
    }


    private function formatDateToDB($fecha){
        return  $fecha . "-01" . "-01";
    }



    private function getIndicadorConfigByKey($idIndicador, $fecha){
        $em = $this->getDoctrine()->getManager();
        $config = $this->getDoctrine()->getRepository('AppBundle:Valoresindicadoresconfigfecha')
                               ->findByMultipleKey($idIndicador, $fecha);
        if ($config){
            return $config[0];
        }         
        return NULL;
    }

    private function constructDesglocesConfig($adminDesgloces, $userDesgloces, $desgloces, $etiquetasDesgloces){
        $desglocesConfig = array();
        foreach ($adminDesgloces as $adminDesgloce) {
            $configFechaDesgloce = $this->getDoctrine()->getRepository('AppBundle:Valoresindicadoresconfigfechadesgloces');
            $desglocesConfig[$adminDesgloce->getIddesgloce()] = array(
                "label" => $desgloces[$adminDesgloce->getIddesgloce()],
                "checked" => in_array($adminDesgloce->getIddesgloce(), $userDesgloces),
                "etiquetas"=> $etiquetasDesgloces[$adminDesgloce->getIddesgloce()]
            );
        }
        return $desglocesConfig;
    }


    private function flatUserDesgloces($desgloces){
        $list = array();
        foreach ($desgloces as $desgloce) {
            array_push($list, $desgloce->getIddesgloce());
        }
        return $list;
    }


    private function getKeyValueEtiquetas($etiquetasList){
        $etiquetas = array();
        foreach ($etiquetasList as $et) {
            $etiquetas[$et->getId()] = $et->getDescripcion();
        }
        return $etiquetas;
    }


    // Transforma un id formateado de etiquetas (n1:n2:...:n3) en string
    // de descripciones correspondientes
    private function mapEtiquetaKeyToString($map, $etiquetaIds){
        $string = "";
        $parts = split(":", $etiquetaIds);
        foreach($parts as $idEtiqueta) {
            $string .= $map[$idEtiqueta];
            if ($idEtiqueta !== end($parts))
                $string .= "/";
        }
        return $string;
    }


    
    /**
     * 
     *
     * @Route("/indicador_save_desgloces_config", name="admin_crud_valoresindicadores_indicador_save_desgloces_config")
     * @Method({"POST"})
     */
    public function saveDesglocesConfigAction(Request $request){
        $content = $this->get("request")->getContent();
        if (!empty($content)){
            $data = json_decode($content, true);
            $response = $this->initSaveDesglocesConfig($data);
            return new JsonResponse($response);
        }
    }


    private function initSaveDesglocesConfig($data){
        $em = $this->getDoctrine()->getManager();
        $response = array("success"=>false);
        $idIndicador = $data["id_indicador"];
        $fecha = $data["fecha"];
        $fecha = $this->formatDateToDB($fecha);
        $desgloces = $data["desgloces_active"];
        $cruzado = $data["desgloces_cross"];
        $configfecha = $this->getIndicadorConfigByKey($idIndicador, $fecha);
        if (!$configfecha){ // solo sigo si NO hay una configuracion ya existente
            try {
                $em->getConnection()->beginTransaction();
                $indicador = $indicador = $this->getDoctrine()->getRepository('AppBundle:Indicadores')->findOneById($idIndicador);
                $valoresindicadoresconfigfecha = new Valoresindicadoresconfigfecha();
                $valoresindicadoresconfigfecha->setIdindicador($indicador);
                $valoresindicadoresconfigfecha->setFecha($fecha);
                $valoresindicadoresconfigfecha->setCruzado($cruzado);
                $em->persist($valoresindicadoresconfigfecha);
                $em->flush();
                if (count($desgloces)){
                    foreach ($desgloces as $idDesgloce){
                        $cfd = new Valoresindicadoresconfigfechadesgloces();
                        $cfd->setIddesgloce($idDesgloce);
                        $cfd->setIdvaloresindicadoresconfigfecha($valoresindicadoresconfigfecha->getId());
                        $em->persist($cfd);
                    }
                } else { // Si no se recibio ningun desgloce, se setea el desgloce 0 'Sin desgloce'
                    $cfd = new Valoresindicadoresconfigfechadesgloces();
                        $cfd->setIddesgloce(0);
                        $cfd->setIdvaloresindicadoresconfigfecha($valoresindicadoresconfigfecha->getId());
                        $em->persist($cfd);
                }
                $em->flush();
                $em->getConnection()->commit();
                $response["success"] = true;
                $response["msg"] = "Configuración guardada con éxito";
            } catch(\Exception $e){
                $em->getConnection()->rollback();
                $response["success"] = false;
                $response["msg"] = "Ha ocurrido un error mientras se intentaba guardar la configuración";
                $response["exception"] = $e;
            }
        }
        return $response;
    }

}
