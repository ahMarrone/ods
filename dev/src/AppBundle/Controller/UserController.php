<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * User controller.
 *
 * @Route("/users")
 */
class UserController extends Controller
{

	/**
     * Muestra perfil/datos de usuario
     *
     * @Route("/profile", name="user_profile")
     * @Method("GET")
     */
    public function profileAction()
    {

        return $this->render('user/profile.html.twig', array());
    }


}