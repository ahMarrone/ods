<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * PanelUser controller.
 *
 * @Route("/paneluser")
 */
class PanelUserController extends Controller
{

	/**
     * Muestra panel de usuario.
     *
     * @Route("/", name="paneluser_index")
     * @Method("GET")
     */
    public function indexAction()
    {

        return $this->render('paneluser/index.html.twig', array());
    }

}