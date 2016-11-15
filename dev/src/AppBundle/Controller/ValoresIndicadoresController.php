<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Valoresindicadores;
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
     * @Route("/", name="admin_crud_valoresindicadores_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $valoresindicadores = $em->getRepository('AppBundle:Valoresindicadores')->findAll();
        return $this->render('valoresindicadores/index.html.twig', array(
            'valoresindicadores' => $valoresindicadores,
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
        if ($idIndicador && $fecha){
            $indicador = $this->getDoctrine()->getRepository('AppBundle:Indicadores')->findById($idIndicador)[0];
            $indicadorDesgloces = $this->getDoctrine()->getRepository('AppBundle:Desglocesindicadores')->findByIdindicador($idIndicador);
            //$desglocesEtiquetas =  $this->getEtiquetasDesgloce($indicadorDesgloces);
            list($desgloces, $etiquetasDesgloces) =   $this->getEtiquetasDesgloce($indicadorDesgloces);
            $refGeograficas = $this->getRefGeograficas();
            $valoresindicadores = $this->getDoctrine()->getRepository('AppBundle:Valoresindicadores')
                               ->filterByIndicadorFecha($idIndicador, $fecha);
            $valoresindicadores = $this->parseEntityValoresindicadores($valoresindicadores);
            return $this->render('valoresindicadores/panel_create_valores_indicadores.html.twig', array(
                'fecha' => $fecha,
                'indicador_id' => $indicador->getId(),
                'indicador_desc' => $indicador->getDescripcion(),
                'desgloces' => $desgloces,
                'etiquetas_desgloces' => $etiquetasDesgloces,
                'ref_geograficas' => $refGeograficas,
                'valores_indicadores' => $valoresindicadores,
                'api_urls' => array('edit'=> $this->generateUrl('admin_crud_valoresindicadores_saveobjects'), 
                                    'delete'=> $this->generateUrl('admin_crud_valoresindicadores_deleteobjects')
                )
        ));
        } else {
            echo var_dump($this->getRequest()->request->all());
           //return $this->redirectToRoute('admin_crud_indicadores_index'); 
        }
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
            array_push($list, array('id'=>$o->getId(),'desc'=>$o->getDescripcion()));
        }
        return $list;
    }

    private function getMetasPreload(){
        $list = array();
        $metas =  $this->getDoctrine()->getRepository('AppBundle:Metas')->findAll();
        foreach ($metas as $m) {
            array_push($list, array('id'=>$m->getId(),'desc'=>$m->getDescripcion(),'id_objetivo'=>$m->getFkidobjetivo()->getId()));
        }
        return $list;
    }

    private function getIndicadoresPreload(){
        $list = array();
        $indicadores =  $this->getDoctrine()->getRepository('AppBundle:Indicadores')->findAll();
        foreach ($indicadores as $i) {
            array_push($list, array('id'=>$i->getId(),'desc'=>$i->getDescripcion(),'id_meta'=>$i->getFkidmeta()->getId()));
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
        $indicador = $this->getDoctrine()->getRepository('AppBundle:Indicadores')->findOneById($idIndicador);
        $etiquetasMemoization = array();
        $fecha = $data["fecha"];
        $objects = $data["objects"];
        $em = $this->getDoctrine()->getManager();
        $response = array("success"=>false);
        try {
            $em->getConnection()->beginTransaction();
            $fechaModif = date_format(new \DateTime(), 'Y-m-d H:i:s');
            foreach ($objects as $refId => $refGeograficaObjects){
                $refgeografica = $this->getDoctrine()->getRepository('AppBundle:Refgeografica')->findOneById($refId);
                foreach ($refGeograficaObjects as $valorIndicadorData) { 
                    $vi = new Valoresindicadores();
                    $vi->setIdusuario($userLogued);
                    $vi->setValor($valorIndicadorData["value"]);
                    $vi->setIdEtiqueta($valorIndicadorData["id_etiqueta"]);
                    $vi->setIdindicador($indicador);
                    $vi->setIdrefgeografica($refgeografica);
                    $vi->setAprobado(false);
                    $date = new \DateTime($fecha);
                    $vi->setFecha(date_format($date, 'Y-m-d'));
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
        return $response;
    }

    /*
    private function memoizeEtiquetas(&$list, $id){
        if (!array_key_exists($id, $list)){
            $list[$id] = $this->getDoctrine()->getRepository('AppBundle:Etiquetas')->findOneById($id);
        }
        return $list[$id];
    }*/

    private function getRefGeograficas(){
        $ret = array();
        $refs =  $this->getDoctrine()->getRepository('AppBundle:Refgeografica')->findAll();
        foreach ($refs as $r) {
            $ret[$r->getId()] = array('desc'=>$r->getDescripcion(),'used'=>false);
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
            array_push($desgloces,$desgloce->getDescripcion());
            $tmpEtiquetas = array();
            foreach ($etiquetas as $e) {
                array_push($tmpEtiquetas, array("id_etiqueta"=>$e->getId(), "desc"=>$e->getDescripcion()));
            }
            array_push($etiquetasDesgloce, $tmpEtiquetas);
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
        $indicador = $this->getDoctrine()->getRepository('AppBundle:Indicadores')->findOneById($idIndicador);
        $fecha = $data["fecha"];
        $objects = $data["objects"];
        $refGeografica = null;
        $em = $this->getDoctrine()->getManager();
        try {
            $em->getConnection()->beginTransaction();
            // elimino todas las tuplas de ese, indicador, para esa fecha, y de esa ref_geografica
            foreach ($objects as $refGeograficaID){  
                $valoresindicadores = $this->getDoctrine()->getRepository('AppBundle:Valoresindicadores')
                                    ->findByMultipleKey($idIndicador, $refGeograficaID, $fecha);
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
                $valoresindicadores = $this->getDoctrine()->getRepository('AppBundle:Valoresindicadores')
                                    ->findByFullKey($valorIndicador["indicador"],
                                                    $valorIndicador["refGeografica"], 
                                                    $valorIndicador["fecha"],
                                                    $valorIndicador["etiqueta"]);
                $valoresindicadores = $valoresindicadores[0];
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



}
