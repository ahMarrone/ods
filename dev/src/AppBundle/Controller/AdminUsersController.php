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
     * ABM de usuarios
     *
     * @Route("/", name="users_admin")
     * @Method("GET")
     */
    public function indexAction()
    {

        return $this->render('useradmin/index.html.twig', array());
    }


}