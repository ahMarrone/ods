<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Desgloces;
use AppBundle\Form\DesglocesType;

/**
 * Desgloces controller.
 *
 * @Route("/admin/crud/desgloces")
 */
class DesglocesController extends Controller
{
    /**
     * Lists all Desgloces entities.
     *
     * @Route("/", name="admin_crud_desgloces_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $desgloces = $em->getRepository('AppBundle:Desgloces')->findAll();

        return $this->render('desgloces/index.html.twig', array(
            'desgloces' => $desgloces,
        ));
    }

    /**
     * Creates a new Desgloces entity.
     *
     * @Route("/new", name="admin_crud_desgloces_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $desgloce = new Desgloces();
        $form = $this->createForm('AppBundle\Form\DesglocesType', $desgloce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($desgloce);
            $em->flush();

            return $this->redirectToRoute('admin_crud_desgloces_index');
        }

        return $this->render('desgloces/new.html.twig', array(
            'desgloce' => $desgloce,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Desgloces entity.
     *
     * @Route("/{id}", name="admin_crud_desgloces_show")
     * @Method("GET")
     */
    public function showAction(Desgloces $desgloce)
    {
        $deleteForm = $this->createDeleteForm($desgloce);

        return $this->render('desgloces/show.html.twig', array(
            'desgloce' => $desgloce,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Desgloces entity.
     *
     * @Route("/{id}/edit", name="admin_crud_desgloces_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Desgloces $desgloce)
    {
        $deleteForm = $this->createDeleteForm($desgloce);
        $editForm = $this->createForm('AppBundle\Form\DesglocesType', $desgloce);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($desgloce);
            $em->flush();

            return $this->redirectToRoute('admin_crud_desgloces_index');
        }

        return $this->render('desgloces/edit.html.twig', array(
            'desgloce' => $desgloce,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Desgloces entity.
     *
     * @Route("/{id}", name="admin_crud_desgloces_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Desgloces $desgloce)
    {
        $form = $this->createDeleteForm($desgloce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($desgloce);
            $em->flush();
        }

        return $this->redirectToRoute('admin_crud_desgloces_index');
    }

    /**
     * Creates a form to delete a Desgloces entity.
     *
     * @param Desgloces $desgloce The Desgloces entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Desgloces $desgloce)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_crud_desgloces_delete', array('id' => $desgloce->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
