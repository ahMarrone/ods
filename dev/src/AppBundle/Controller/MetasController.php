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
     * @Route("/list", requirements={"admin_crud_metas_index":"\d+"}, name="admin_crud_metas_index")
     * @Route("/list/{id_objetivo}", requirements={"admin_crud_metas_index_idObjetivo":"\d+"}, name="admin_crud_metas_index_idObjetivo", defaults={"admin_crud_metas_index_idObjetivo" = 0})
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $id_objetivo = $request->get('id_objetivo');
        $em = $this->getDoctrine()->getManager();
        
        if (intval($id_objetivo) == 0)
        {
            $metas = $em->getRepository('AppBundle:Metas')->findAll();
            $titulo_objetivo = "TODOS";
        }
        else
        {

            $objetivo = $em->getRepository('AppBundle:Objetivos')->findOneById($id_objetivo);
            $titulo_objetivo = $objetivo->getDescripcion();
            $metas = $em->getRepository('AppBundle:Metas')->findByfkidobjetivo($id_objetivo);            
        }

        return $this->render('metas/index.html.twig', array(
            'metas' => $metas,
            'titulo_objetivo' => $titulo_objetivo,
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
        $form = $this->createForm('AppBundle\Form\MetasType', $meta, array(
            'scopes_enabled' => $this->getEnabledScopes(),
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addMetaMetadata($meta);
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
     * @Route("/detail/{id}", name="admin_crud_metas_show")
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
        $editForm = $this->createForm('AppBundle\Form\MetasType', $meta, array(
            'scopes_enabled' => array('N'=>false,'P'=>false,'D'=>false), // en modo edicion, no se puede cambiar el ambito de la meta
        ));
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->addMetaMetadata($meta);
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


    private function addMetaMetadata(&$meta){
        $meta->setIdusuario($this->getUser());
        $meta->setFechamodificacion(date_format(new \DateTime(), 'Y-m-d H:i:s'));
    }


    private function getEnabledScopes(){
        $scope = $this->get('app.utils.scopes_service');
        return $scope->getMetasScopes();
    }
}
