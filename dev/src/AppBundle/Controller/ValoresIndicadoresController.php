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
        ));
    }

    /**
     * Crea/Actualiza instancias de ValoresIndicadores.
     *
     * @Route("/new", name="admin_crud_valoresindicadores_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $idIndicador =  $request->query->get('id_indicador', NULL);
        $idDesgloce =  $request->query->get('id_desgloce', NULL);
        $fecha =  $request->query->get('fecha', NULL);
        if ($idIndicador){
            $indicador = $this->getDoctrine()->getRepository('AppBundle:Indicadores')->findById($idIndicador)[0];
            //echo var_dump($indicador);
            $desgloce = $this->getDoctrine()->getRepository('AppBundle:Desgloces')->findOneById($idDesgloce);
            $etiquetas =  $this->getEtiquetasDesgloce($idDesgloce);
            //$ref_geograficas = $this->filterRefGeograficas($indicador->getAmbito());
            $ref_geograficas = $this->getRefGeograficas();
            $valoresindicadores = $this->getDoctrine()->getRepository('AppBundle:Valoresindicadores')
                               ->filterByIndicadorFechaDesgloce($idIndicador, $fecha, $idDesgloce);
            return $this->render('valoresindicadores/panel_create_valores_indicadores.html.twig', array(
                'fecha' => $fecha,
                'indicador_id' => $indicador->getId(),
                'indicador_desc' => $indicador->getDescripcion(),
                'desgloce' => $desgloce->getDescripcion(),
                'etiquetas' => $etiquetas,    
                'ref_geograficas' => $ref_geograficas,
                'valores_indicadores' => $this->parseEntityValoresindicadores($valoresindicadores),
                'api_urls' => array('edit'=> $this->generateUrl('admin_crud_valoresindicadores_saveobjects'), 
                                    'delete'=> $this->generateUrl('admin_crud_valoresindicadores_deleteobjects')
                )
        ));
        } else {
           return $this->redirectToRoute('admin_crud_indicadores_index'); 
        }
    }

    private function parseEntityValoresindicadores($valoresindicadores){
        $ret = array();
        foreach ($valoresindicadores as $vi){
            $data = array(
                'id_etiqueta' => $vi->getIdetiqueta()->getId(),
                'id_ref_geografica' => $vi->getIdrefgeografica()->getId(),
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
     * @Method({"GET", "POST"})
     */
    public function preloadAction(Request $request){

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
        $idIndicador = $data["id_indicador"];
        $indicador = $this->getDoctrine()->getRepository('AppBundle:Indicadores')->findOneById($idIndicador);
        $etiquetasMemoization = array();
        $fecha = $data["fecha"];
        $objects = $data["objects"];
        $em = $this->getDoctrine()->getManager();
        $response = array("success"=>false);
        try {
            $em->getConnection()->beginTransaction();
            foreach ($objects as $refId => $refGeograficaObjects){
                $refgeografica = $this->getDoctrine()->getRepository('AppBundle:Refgeografica')->findOneById($refId);
                foreach ($refGeograficaObjects as $valorIndicadorData) { 
                    $vi = new Valoresindicadores();
                    $etiqueta = $this->memoizeEtiquetas($etiquetasMemoization, $valorIndicadorData["id_etiqueta"]);
                    //$etiqueta->setId($valorIndicadorData["id_etiqueta"]);
                    $vi->setValor($valorIndicadorData["value"]);
                    $vi->setIdEtiqueta($etiqueta);
                    $vi->setIdindicador($indicador);
                    $vi->setIdrefgeografica($refgeografica);
                    $vi->setAprobado(false);
                    $date = new \DateTime($fecha);
                    $vi->setFecha(date_format($date, 'Y-m-d'));
                    $em->merge($vi); // persisto valorindicador
                }
            }
            $em->flush();
            $em->getConnection()->commit();
            $response["success"] = true;
        } catch (\Exception $e) {
            $em->getConnection()->rollback();
            $response["success"] = false;
            $response["msg"] = "Ha ocurrido un error mientras se intentaban dar de alta los valores indicadores";
            $response["exception"] = $e;
            throw $e;
        }
        return $response;
    }

    private function memoizeEtiquetas(&$list, $id){
        if (!array_key_exists($id, $list)){
            $list[$id] = $this->getDoctrine()->getRepository('AppBundle:Etiquetas')->findOneById($id);
        }
        return $list[$id];
    }

    private function getRefGeograficas(){
        $ret = array();
        $refs =  $this->getDoctrine()->getRepository('AppBundle:Refgeografica')->findAll();
        foreach ($refs as $r) {
            $ret[$r->getId()] = array('desc'=>$r->getDescripcion(),'used'=>false);
        }
        return $ret;
    }

    // Retorna diccionario, con etiquetas como claves, y lista de sus etiquetas como valor
    private function getEtiquetasDesgloce($idDesgloce){
        $etiquetasDesgloce = array();
        $etiquetas =  $this->getDoctrine()->getRepository('AppBundle:Etiquetas')->findByFkiddesgloce($idDesgloce);
        foreach ($etiquetas as $e) {
                $etiquetasDesgloce[$e->getId()] = $e->getDescripcion();
        }
        return $etiquetasDesgloce;
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



}
