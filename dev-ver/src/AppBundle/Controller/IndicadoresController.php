<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Indicadores;
use AppBundle\Form\IndicadoresType;

/**
 * Indicadores controller.
 *
 * @Route("/admin/crud/indicadores")
 */
class IndicadoresController extends Controller
{
    /**
     * Lists all Indicadores entities.
     *
     * @Route("/", name="admin_crud_indicadores_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $indicadores = $em->getRepository('AppBundle:Indicadores')->findAll();

        return $this->render('indicadores/index.html.twig', array(
            'indicadores' => $indicadores,
        ));
    }

    /**
     * Creates a new Indicadores entity.
     *
     * @Route("/new", name="admin_crud_indicadores_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $indicadore = new Indicadores();
        $form = $this->createForm('AppBundle\Form\IndicadoresType', $indicadore);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($indicadore);
            $em->flush();

            //return $this->redirectToRoute('admin_crud_desglocesporindicador_new', array('id_indicador' => $indicadore->getId()));
        }

        return $this->render('indicadores/new.html.twig', array(
            'indicadore' => $indicadore,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Indicadores entity.
     *
     * @Route("/{id}", name="admin_crud_indicadores_show")
     * @Method("GET")
     */
    public function showAction(Indicadores $indicadore)
    {
        $deleteForm = $this->createDeleteForm($indicadore);

        return $this->render('indicadores/show.html.twig', array(
            'indicadore' => $indicadore,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Indicadores entity.
     *
     * @Route("/{id}/edit", name="admin_crud_indicadores_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Indicadores $indicadore)
    {
        // Hack de Agustín para castear un string en un boolean (ya no hace falta)
        //echo var_dump($indicadore->getVisiblenacional());
        //$nac = ($indicadore->getVisiblenacional()) ? true : false;
        //$indicadore->setVisiblenacional($nac);
        
        $deleteForm = $this->createDeleteForm($indicadore);
        $editForm = $this->createForm('AppBundle\Form\IndicadoresType', $indicadore);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($indicadore);
            $em->flush();

            return $this->redirectToRoute('admin_crud_indicadores_edit', array('id' => $indicadore->getId()));
        }

        return $this->render('indicadores/edit.html.twig', array(
            'indicadore' => $indicadore,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Indicadores entity.
     *
     * @Route("/{id}", name="admin_crud_indicadores_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Indicadores $indicadore)
    {
        $form = $this->createDeleteForm($indicadore);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($indicadore);
            $em->flush();
        }

        return $this->redirectToRoute('admin_crud_indicadores_index');
    }

    /**
     * Creates a form to delete a Indicadores entity.
     *
     * @param Indicadores $indicadore The Indicadores entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Indicadores $indicadore)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_crud_indicadores_delete', array('id' => $indicadore->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
