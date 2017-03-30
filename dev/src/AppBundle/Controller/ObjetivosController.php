<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Objetivos;
use AppBundle\Form\ObjetivosType;

/**
 * Objetivos controller.
 *
 * @Route("/admin/crud/objetivos")
 */
class ObjetivosController extends Controller
{
    /**
     * Lists all Objetivos entities.
     *
     * @Route("/", name="admin_crud_objetivos_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $objetivos = $em->getRepository('AppBundle:Objetivos')->findAll();

        return $this->render('objetivos/index.html.twig', array(
            'objetivos' => $objetivos,
        ));
    }

    /**
     * Creates a new Objetivos entity.
     *
     * @Route("/new", name="admin_crud_objetivos_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        // NO SE PERMITE ALTA DE OBJETIVOS
        /*$objetivo = new Objetivos();
        $form = $this->createForm('AppBundle\Form\ObjetivosType', $objetivo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($objetivo);
            $em->flush();

            return $this->redirectToRoute('admin_crud_objetivos_show', array('id' => $objetivo->getId()));
        }

        return $this->render('objetivos/new.html.twig', array(
            'objetivo' => $objetivo,
            'form' => $form->createView(),
        ));*/
        return $this->redirectToRoute('admin_crud_objetivos_index');
    }

    /**
     * Finds and displays a Objetivos entity.
     *
     * @Route("/{id}", name="admin_crud_objetivos_show")
     * @Method("GET")
     */
    public function showAction(Objetivos $objetivo)
    {
        $deleteForm = $this->createDeleteForm($objetivo);

        return $this->render('objetivos/show.html.twig', array(
            'objetivo' => $objetivo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Objetivos entity.
     *
     * @Route("/{id}/edit", name="admin_crud_objetivos_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Objetivos $objetivo)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', $this->getUser(), 'No tiene permisos para ingresar a esta página!');
        $deleteForm = $this->createDeleteForm($objetivo);
        $editForm = $this->createForm('AppBundle\Form\ObjetivosType', $objetivo, array(
                'disable_form' => true,
            )
        );
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($objetivo);
            $em->flush();
            $this->get('app.utils.scopes_service')->addEditSuccessToRequest($request);
            return $this->redirectToRoute('admin_crud_objetivos_index');
        }

        return $this->render('objetivos/edit.html.twig', array(
            'objetivo' => $objetivo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Objetivos entity.
     *
     * @Route("/{id}", name="admin_crud_objetivos_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Objetivos $objetivo)
    {
        $form = $this->createDeleteForm($objetivo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($objetivo);
            $em->flush();
        }

        return $this->redirectToRoute('admin_crud_objetivos_index');
    }

    /**
     * Creates a form to delete a Objetivos entity.
     *
     * @param Objetivos $objetivo The Objetivos entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Objetivos $objetivo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_crud_objetivos_delete', array('id' => $objetivo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
