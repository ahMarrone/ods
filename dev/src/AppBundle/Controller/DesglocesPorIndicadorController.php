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

        return $this->render('indicadores/desglocesporindicador.html.twig', array(
            'desgloces' => $desgloces,
            'indicador' => $indicador,
            'edit_form' => $form->createView(),
            'nombre_indicador' => $indicador->getDescripcion(),
        ));   
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
}
