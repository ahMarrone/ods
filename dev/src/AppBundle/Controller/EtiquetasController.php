<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Etiquetas;
use AppBundle\Form\EtiquetasType;

/**
 * Etiquetas controller.
 *
 * @Route("/admin/crud/etiquetas")
 */
class EtiquetasController extends Controller
{
    /**
     * Lists all Etiquetas entities.
     *
     * @Route("/", name="admin_crud_etiquetas_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $etiquetas = $em->getRepository('AppBundle:Etiquetas')->findAll();

        return $this->render('etiquetas/index.html.twig', array(
            'etiquetas' => $etiquetas,
        ));
    }

    /**
     * Creates a new Etiquetas entity.
     *
     * @Route("/new", name="admin_crud_etiquetas_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $etiqueta = new Etiquetas();
        $form = $this->createForm('AppBundle\Form\EtiquetasType', $etiqueta);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($etiqueta);
            $em->flush();

            return $this->redirectToRoute('admin_crud_etiquetas_show', array('id' => $etiqueta->getId()));
        }

        return $this->render('etiquetas/new.html.twig', array(
            'etiqueta' => $etiqueta,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Etiquetas entity.
     *
     * @Route("/{id}", name="admin_crud_etiquetas_show")
     * @Method("GET")
     */
    public function showAction(Etiquetas $etiqueta)
    {
        $deleteForm = $this->createDeleteForm($etiqueta);

        return $this->render('etiquetas/show.html.twig', array(
            'etiqueta' => $etiqueta,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Etiquetas entity.
     *
     * @Route("/{id}/edit", name="admin_crud_etiquetas_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Etiquetas $etiqueta)
    {
        $deleteForm = $this->createDeleteForm($etiqueta);
        $editForm = $this->createForm('AppBundle\Form\EtiquetasType', $etiqueta);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($etiqueta);
            $em->flush();

            return $this->redirectToRoute('admin_crud_etiquetas_edit', array('id' => $etiqueta->getId()));
        }

        return $this->render('etiquetas/edit.html.twig', array(
            'etiqueta' => $etiqueta,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Etiquetas entity.
     *
     * @Route("/{id}", name="admin_crud_etiquetas_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Etiquetas $etiqueta)
    {
        $form = $this->createDeleteForm($etiqueta);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($etiqueta);
            $em->flush();
        }

        return $this->redirectToRoute('admin_crud_etiquetas_index');
    }

    /**
     * Creates a form to delete a Etiquetas entity.
     *
     * @param Etiquetas $etiqueta The Etiquetas entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Etiquetas $etiqueta)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_crud_etiquetas_delete', array('id' => $etiqueta->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
