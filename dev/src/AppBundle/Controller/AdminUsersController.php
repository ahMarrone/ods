<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * AdminUsers controller.
 *
 * @Route("/admin/users")
 */
class AdminUsersController extends Controller
{

    /**
     * Lists all Usuarios entities.
     *
     * @Route("/", name="admin_users_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $usuarios = $em->getRepository('AppBundle:Usuarios')->findAll();
        $service = $this->get('app.utils.scopes_service');
        return $this->render('useradmin/index.html.twig', array(
            'usuarios' => $usuarios,
            'roles_map' => $service->getMapRoles()
        ));
    }


}