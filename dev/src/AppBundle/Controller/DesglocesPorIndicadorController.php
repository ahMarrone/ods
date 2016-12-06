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
    public function newAction(Request $request, $id_indicador)
    {
        
        $em = $this->getDoctrine()->getManager();
        $desgloces = $em->getRepository('AppBundle:Desgloces')->findAll();
        $indicador = $em->getRepository('AppBundle:Indicadores')->findOneById($id_indicador);
        $etiquetas = $em->getRepository('AppBundle:Etiquetas')->findAll();

        /*var_dump($etiquetas);
        echo "<hr>";
        print $etiquetas[1]->getId() ;
        echo "<hr>";
        #print $etiquetas[0].getDescripcion();
        echo "<hr>";
        */
        $etiquetas_desgloces = array();

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

        $form = $this->createForm('AppBundle\Form\DesglocesPorIndicadorType', $desgloces, array('idIndicador' => $indicador,
            'method' => 'GET', 'label' => $etiquetas_desgloces)
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            // Grabo la relacion "Sin desgloce"
            $thisDI = new Desglocesindicadores();
            $thisDI->setIdindicador($indicador->getId());
            $thisDI->setIddesgloce(0);
            $em->persist($thisDI);
            // Por cada desgloce seleccionado, grabo en la relación
            $desglocesSeleccionados = $form['desglocesSeleccionados']->getdata();
            foreach ($desglocesSeleccionados as $key => $value) {
                // Crear instancia de Desglocesindicadores
                $thisDI = new Desglocesindicadores();
                // Setear valores
                $thisDI->setIdindicador($indicador->getId());
                $thisDI->setIddesgloce($value);
                // Grabar
                $em->persist($thisDI);
            }
            $em->flush();
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
