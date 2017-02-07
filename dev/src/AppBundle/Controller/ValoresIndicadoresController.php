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
        }
        return $this->render('valoresindicadores/index.html.twig', array(
            'valoresindicadores' => $valoresindicadores,
            'etiquetas'=> $etiquetas,
            'indicador_desc' => $indicadorDesc,
            'api_urls' => array('aproveData'=> $this->generateUrl('admin_crud_valoresindicadores_aproveData'))
        ));
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
        $fecha =  (isset($params["fecha"])) ? $params["fecha"] : NULL;
        $fecha = $this->formatDateToDB($fecha);
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
            return $this->render('valoresindicadores/panel_create_valores_indicadores.html.twig', array(
                'fecha' => $fecha,
                'indicador_id' => $indicador->getId(),
                'indicador_desc' => $indicador->getDescripcion(),
                'indicador_ambito' => $ambitoIndicador,
                'desgloces' => $desgloces,
                'etiquetas_desgloces' => $etiquetasDesgloces,
                'cruzado' => $cruzado,
                'ref_geograficas' => $refGeograficas,
                'filter_ref_geograficas' => $this->getParentRefGeograficas($ambitoIndicador),
                'valores_indicadores' => $valoresindicadores,
                'step' => $step,
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
     * @Method({"GET"})
     */
    public function preloadAction(Request $request){
        list($objetivos, $metas, $indicadores) = $this->preparePreloadData();
        return $this->render('valoresindicadores/preload.html.twig', array(
            'objetivos'=>$objetivos,
            'metas'=>$metas,
            'indicadores'=>$indicadores,
            'api_urls' => array(
                'indicador_dates'=> $this->generateUrl('admin_crud_valoresindicadores_indicador_dates'),
                'indicador_desgloces_config' => $this->generateUrl('admin_crud_valoresindicadores_indicador_desgloces_config'),
                'save_desgloces_config' => $this->generateUrl('admin_crud_valoresindicadores_indicador_save_desgloces_config')
            )
        ));
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
                $agrupamiento = $this->getDoctrine()->getRepository('AppBundle:Agrupamientorefgeografica')->findBy(
             array('id_1' => $r->getId()));
                $parent = $agrupamiento[0]->getId2();
            }
            $ret[$r->getId()] = array('desc'=>$r->getDescripcion(),'used'=>false,'parent'=>$parent);
        }
        return $ret;
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
