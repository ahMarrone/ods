<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Valoresindicadores;
use AppBundle\Form\ValoresIndicadoresType;

/**
 * ValoresIndicadores controller.
 *
 * @Route("/admin/crud/valoresindicadores")
 */
class ValoresIndicadoresController extends Controller
{
    /**
     * Lists all ValoresIndicadores entities.
     *
     * @Route("/", name="admin_crud_valoresindicadores_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $valoresindicadores = $em->getRepository('AppBundle:Valoresindicadores')->findAll();
        return $this->render('valoresindicadores/index.html.twig', array(
            'valoresindicadores' => $valoresindicadores,
        ));
    }

    /**
     * Creates a new Indicadores entity.
     *
     * @Route("/new", name="admin_crud_valoresindicadores_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
    }

    /**
     * Finds and displays a ValoresIndicadores entity.
     *
     * @Route("/{id}", name="admin_crud_valoresindicadores_show")
     * @Method("GET")
     */
    public function showAction(Valoresindicadores $valoresindicadores)
    {
    }

    /**
     * Displays a form to edit an existing ValoresIndicadores entity.
     *
     * @Route("/{id}/edit", name="admin_crud_valoresindicadores_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Valoresindicadores $valoresindicadores)
    {
    }

    /**
     * Deletes a Indicadores entity.
     *
     * @Route("/{id}", name="admin_crud_indicadores_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Valoresindicadores $valoresindicadores)
    {
    }

    /**
     * Creates a form to delete a Indicadores entity.
     *
     * @param Indicadores $indicadore The Indicadores entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Valoresindicadores $valoresindicadores)
    {
    }
}
