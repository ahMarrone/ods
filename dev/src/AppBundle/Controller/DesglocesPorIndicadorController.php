<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Desglocesindicadores;
use AppBundle\Entity\Desgloces;
use AppBundle\Entity\Etiquetas;

//use AppBundle\Form\IndicadoresType;

/**
 * Indicadores controller.
 *
 * @Route("/admin/crud")
 */
class DesglocesPorIndicadorController extends Controller
{
    /**
     * Poner qué hace!
     *
     * @Route("/desglocesporindicador/{id_indicador}", requirements={"id_indicador":"\d+"}, name="admin_crud_desglocesporindicador_new")
     * @Method("GET")
     */
    public function newAction(Request $request, $id_indicador){

        $etiquetas_desgloces = array();
        $desgloces_seleccionados = array();
        
        $em = $this->getDoctrine()->getManager();
        $desgloces = $em->getRepository('AppBundle:Desgloces')->findAll();
        $indicador = $em->getRepository('AppBundle:Indicadores')->findOneById($id_indicador);
        $etiquetas = $em->getRepository('AppBundle:Etiquetas')->findAll();

        $desgloces_indicador =  $em->getRepository('AppBundle:Desglocesindicadores')->findByIdindicador($id_indicador);


        foreach ($desgloces_indicador as $di){
            array_push($desgloces_seleccionados, $di->getIddesgloce());
        }

        foreach ($etiquetas as $key => $value) {
            $etiqueta_descripcion = $value->getDescripcion();
            $idDesgloce = $value->getFkiddesgloce()->getId();
            if (isset($etiquetas_desgloces[$idDesgloce]))
            {
                $etiquetas_desgloces[$idDesgloce] = $etiquetas_desgloces[$idDesgloce] . " [" . $etiqueta_descripcion . "]"; 
            }
            else
            {
                $etiquetas_desgloces[$idDesgloce] = "[" . $etiqueta_descripcion . "]";
            }
        }
        $form = $this->createForm('AppBundle\Form\DesglocesPorIndicadorType', $desgloces, array(
            'idIndicador' => $indicador,
            'method' => 'GET', 
            'label' => $etiquetas_desgloces,
            'desgloces_seleccionados' => $desgloces_seleccionados,
            )
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            // Por cada desgloce seleccionado, grabo en la relación
            $desglocesSeleccionados = $form['desglocesSeleccionados']->getdata();
            foreach ($desglocesSeleccionados as $key => $value) {
                // Crear instancia de Desglocesindicadores
                $thisDI = new Desglocesindicadores();
                // Setear valores
                $thisDI->setIdindicador($indicador->getId());
                $thisDI->setIddesgloce($value);
                // Grabar
                if (!$this->desgloceIndicadorExists($thisDI)){
                    $em->persist($thisDI);
                }
            }
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', "La configuración de desgloses del indicador ha sido actualizada correctamente");
            return $this->redirectToRoute('admin_crud_indicadores_index');
        }

        // Armo datos para tabla de configuracion por fecha
        $config_by_fecha = array();
        $configsfecha = $this->getIndicadorConfigById($id_indicador);
        foreach ($configsfecha as $config) {
            $userDesgloces = $this->getDoctrine()->getRepository('AppBundle:Valoresindicadoresconfigfechadesgloces')->findByIdvaloresindicadoresconfigfecha($config->getId());
            list($desgloces, $etiquetasDesgloces) = $this->getEtiquetasDesgloce($userDesgloces);
            $cantValoresIndicadores = $this->getDoctrine()->getRepository('AppBundle:Valoresindicadores')->findByIdvaloresindicadoresconfigfecha($config->getId());
            $config_by_fecha[$config->getId()] = array('fecha' => $config->getFecha(), 'cruzado' => $config->getCruzado(),'desgloces'=> $desgloces, 'etiquetas_desgloces'=> $etiquetasDesgloces, 'cant_valores'=> count($cantValoresIndicadores));
        }
        return $this->render('indicadores/desglocesporindicador.html.twig', array(
            'desgloces' => $desgloces,
            'indicador' => $indicador,
            'edit_form' => $form->createView(),
            'nombre_indicador' => $indicador->getDescripcion(),
            'config_by_fecha' => $config_by_fecha,
            'api_urls' => array('deleteData'=> $this->generateUrl('admin_crud_desglocesporindicador_delete', array('id_indicador'=>$indicador->getId(), 'id_config'=>0)))
        ));   
    }

    /**
   * @Route("/desglocesporindicador/delete/{id_indicador}/{id_config}", requirements={"id_indicador":"\d+", "id_config":"\d+"}, name="admin_crud_desglocesporindicador_delete"))
   *  @Method("GET")
   */
    public function deleteAction(Request $request, $id_indicador, $id_config){ 
        $configToDelete = $this->getDoctrine()->getRepository('AppBundle:Valoresindicadoresconfigfecha')
                               ->findOneById($id_config);
        if ($configToDelete){
            // tengo que eliminar los datos en valoresIndicadoresConfigFechaDesgloces y valoresIndicadoresConfigFecha
            $em = $this->getDoctrine()->getManager();
            $userDesgloces = $this->getDoctrine()->getRepository('AppBundle:Valoresindicadoresconfigfechadesgloces')->findByIdvaloresindicadoresconfigfecha($id_config);
            foreach ($userDesgloces as $desglose){
                $em->remove($desglose);
            }            
            $em->remove($configToDelete);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', "La configuración para el período seleccionado ha sido eliminada");
        }
        return $this->redirectToRoute('admin_crud_desglocesporindicador_new', array('id_indicador'=>$id_indicador));
    }





    private function desgloceIndicadorExists($desgloceIndicador){
        $em = $this->getDoctrine()->getManager();
        $diDB =  $em->getRepository('AppBundle:Desglocesindicadores')->findBy(
            array('idindicador' => $desgloceIndicador->getIdindicador() , 'iddesgloce' => $desgloceIndicador->getIddesgloce()
        ));
        if (count($diDB) > 0 ){
            return true;
        } else {
            return false;
        }
    }


    private function getIndicadorConfigById($idIndicador){
        $em = $this->getDoctrine()->getManager();
        $config = $this->getDoctrine()->getRepository('AppBundle:Valoresindicadoresconfigfecha')
                               ->findByIdindicador($idIndicador);
        if ($config){
            return $config;
        }         
        return array();
    }

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
}
