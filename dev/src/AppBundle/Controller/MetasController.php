<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Metas;
use AppBundle\Form\MetasType;

/**
 * Metas controller.
 *
 * @Route("/admin/crud/metas")
 */
class MetasController extends Controller
{
    /**
     * Lists all Metas entities.
     *
     * @Route("/", name="admin_crud_metas_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $metas = $em->getRepository('AppBundle:Metas')->findAll();

        return $this->render('metas/index.html.twig', array(
            'metas' => $metas,
        ));
    }

    /**
     * Creates a new Metas entity.
     *
     * @Route("/new", name="admin_crud_metas_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $meta = new Metas();
        $form = $this->createForm('AppBundle\Form\MetasType', $meta);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($meta);
            $em->flush();

            return $this->redirectToRoute('admin_crud_metas_show', array('id' => $meta->getId()));
        }

        return $this->render('metas/new.html.twig', array(
            'meta' => $meta,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Metas entity.
     *
     * @Route("/{id}", name="admin_crud_metas_show")
     * @Method("GET")
     */
    public function showAction(Metas $meta)
    {
        $deleteForm = $this->createDeleteForm($meta);

        return $this->render('metas/show.html.twig', array(
            'meta' => $meta,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Metas entity.
     *
     * @Route("/{id}/edit", name="admin_crud_metas_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Metas $meta)
    {
        $deleteForm = $this->createDeleteForm($meta);
        $editForm = $this->createForm('AppBundle\Form\MetasType', $meta);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($meta);
            $em->flush();

            return $this->redirectToRoute('admin_crud_metas_edit', array('id' => $meta->getId()));
        }

        return $this->render('metas/edit.html.twig', array(
            'meta' => $meta,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Metas entity.
     *
     * @Route("/{id}", name="admin_crud_metas_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Metas $meta)
    {
        $form = $this->createDeleteForm($meta);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($meta);
            $em->flush();
        }

        return $this->redirectToRoute('admin_crud_metas_index');
    }

    /**
     * Creates a form to delete a Metas entity.
     *
     * @param Metas $meta The Metas entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Metas $meta)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_crud_metas_delete', array('id' => $meta->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
