<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Desglocesindicadores;
use AppBundle\Entity\Desgloces;
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
    public function newAction(Request $request, $id_indicador)
    {
        
        $em = $this->getDoctrine()->getManager();
        $desgloces = $em->getRepository('AppBundle:Desgloces')->findAll();
        $indicador = $em->getRepository('AppBundle:Indicadores')->findOneById($id_indicador);

        $form = $this->createForm('AppBundle\Form\DesglocesPorIndicadorType', $desgloces, array('idIndicador' => $indicador,
            'method' => 'GET',)
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
/*$var = $form->getdata();

            foreach ($var as $key => $value) {
                print_r($key);
                print_r(" >>>>> ");
                print_r($value);
                print_r("<br>");    
                print_r($value->getDescripcion());

            }
            print_r("<br>--------------------<br>");
  */
            $desglocesSeleccionados = $form['desglocesSeleccionados']->getdata();
            // Por cada desgloce seleccionado, grabo en la relación
            foreach ($desglocesSeleccionados as $key => $value) {
                //print_r($key); print_r("-"); print_r($value); print_r("<br>");
                // Crear instancia de Desglocesindicadores
                $thisDI = new Desglocesindicadores();
                // Setear valores
                $thisDI->setIdindicador($indicador->getId());
                $thisDI->setIddesgloce($value);
                // Grabar
                $em->persist($thisDI);
            }
            $em->flush();
            //
            return $this->redirectToRoute('admin_crud_indicadores_show', array('id' => $indicador->getId()));
        }

        return $this->render('indicadores/desglocesporindicador.html.twig', array(
            'desgloces' => $desgloces,
            'indicador' => $indicador,
            'edit_form' => $form->createView(),
            'nombre_indicador' => $indicador->getDescripcion(),
        ));   
    }
}
