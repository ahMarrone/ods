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
 * @Route("/admin/crud/desgloses")
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
        $this->denyAccessUnlessGranted('ROLE_ADMIN', $this->getUser(), 'No tiene permisos para ingresar a esta página!');
        $desgloce = new Desgloces();
        $form = $this->createForm('AppBundle\Form\DesglocesType', $desgloce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($desgloce);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', "El Desglose ha sido dado de alta correctamente");
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
        $this->denyAccessUnlessGranted('ROLE_ADMIN', $this->getUser(), 'No tiene permisos para ingresar a esta página!');
        $deleteForm = $this->createDeleteForm($desgloce);
        $editForm = $this->createForm('AppBundle\Form\DesglocesType', $desgloce);
        $editForm->handleRequest($request);
        $renderDelete = ($desgloce->getId() == 0) ? false : true;
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($desgloce);
            $em->flush();
            $this->get('app.utils.scopes_service')->addEditSuccessToRequest($request);
            return $this->redirectToRoute('admin_crud_desgloces_index');
        }

        return $this->render('desgloces/edit.html.twig', array(
            'desgloce' => $desgloce,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'render_delete' => $renderDelete
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
        $this->denyAccessUnlessGranted('ROLE_ADMIN', $this->getUser(), 'No tiene permisos para ingresar a esta página!');
        $form = $this->createDeleteForm($desgloce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $desgloce->getId() != 0) {
            $em = $this->getDoctrine()->getManager();
            $etiquetasDesgloces = $em->getRepository('AppBundle:Etiquetas')->findByfkiddesgloce($desgloce->getId());
            if (count($etiquetasDesgloces)) {
                $request->getSession()->getFlashBag()->add('warning', "No se puede eliminar un Desglose que tiene Etiquetas asociadas");
                return $this->redirectToRoute('admin_crud_desgloces_index');
            }
            $configFechaDesglose = $this->getDoctrine()->getRepository('AppBundle:Valoresindicadoresconfigfechadesgloces')->findByIddesgloce($desgloce->getId());
            if (count($configFechaDesglose)){
                $request->getSession()->getFlashBag()->add('warning', "No se puede eliminar el Desglose porque existen configuraciones de valores indicadores asociadas al mismo");
                return $this->redirectToRoute('admin_crud_desgloces_index');
            }
            $em->remove($desgloce);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', "El Desglose ha sido eliminado correctamente");
            return $this->redirectToRoute('admin_crud_desgloces_index');
        }
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
