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
     * @Route("/list", name="admin_crud_etiquetas_index")
     * @Route("/list/{id_desgloce}", requirements={"admin_crud_etiquetas_index_idDesgloce":"\d+"}, name="admin_crud_etiquetas_index_idDesgloce", defaults={"admin_crud_etiquetas_index_idDesgloce" = 0})
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id_desgloce = $request->get('id_desgloce');
        if (isset($id_desgloce)){
            $desgloce = $em->getRepository('AppBundle:Desgloces')->findOneById($id_desgloce);
            $etiquetas = $em->getRepository('AppBundle:Etiquetas')->findByfkiddesgloce($id_desgloce);
            $titulo_desgloces = $desgloce->getDescripcion();
        } else {
            $etiquetas = $em->getRepository('AppBundle:Etiquetas')->findAll();
            $titulo_desgloces = "TODOS";
        }

        return $this->render('etiquetas/index.html.twig', array(
            'etiquetas' => $etiquetas,
            'titulo_desgloces' => $titulo_desgloces,
        ));
    }

    /**
     * Creates a new Etiquetas entity.
     *
     * @Route("/new/{id_desglose}", name="admin_crud_etiquetas_new", defaults={"id_desglose" = -1})
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id_desglose = intval($request->get('id_desglose'));
        $desglose = null;
        if ($id_desglose != -1){
            $desglose = $em->getRepository('AppBundle:Desgloces')->findOneById($id_desglose);
        }
        $etiqueta = new Etiquetas();
        $form = $this->createForm('AppBundle\Form\EtiquetasType', $etiqueta);
        $form->handleRequest($request);
        $formData = $form->getData();
        if ($desglose && !$formData->getFkiddesgloce()){
            $form->get('fkiddesgloce')->setData($desglose);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($etiqueta);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', "La Etiqueta ha sido dada de alta correctamente");
            return $this->redirectToRoute('admin_crud_etiquetas_new', array('id_desglose'=> $etiqueta->getFkiddesgloce()->getId()));
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
            $this->get('app.utils.scopes_service')->addEditSuccessToRequest($request);
            return $this->redirectToRoute('admin_crud_etiquetas_index');
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
            $request->getSession()->getFlashBag()->add('success', "La Etiqueta ha sido eliminada correctamente");
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
