<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Indicadores;
use AppBundle\Entity\Desgloces;

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

        //$desgloce = new Desgloces();

        $form = $this->createForm('AppBundle\Form\DesglocesPorIndicadorType', $desgloces, array('idIndicador' => $indicador,));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($indicadore);
            $em->flush();

            return $this->redirectToRoute('admin_crud_indicadores_show', array('id' => $desgloce->getId()));
        }

        return $this->render('indicadores/desglocesporindicador.html.twig', array(
            'desgloces' => $desgloces,
            'indicador' => $indicador,
            'edit_form' => $form->createView(),
            'nombre_indicador' => $indicador->getDescripcion(),
        ));
    }
}
