<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppUserBundle\Controller;

use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Controller managing the user profile.
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
class ProfileController extends Controller
{
    /**
     * Show the user.
     */
    public function showAction(Request $request)
    {   
        $id_user = intval($request->get('id'));
        $user = $this->getDestinationUserObject($id_user);
        $service = $this->get('app.utils.scopes_service');
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return $this->render('FOSUserBundle:Profile:show.html.twig', array(
            'user' => $user,
            'roles_map' => $service->getMapRoles()
        ));
    }

    /**
     * Edit the user.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function editAction(Request $request)
    {
        $id_user = intval($request->get('id'));
        $user = $this->getDestinationUserObject($id_user);
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.profile.form.factory');

        $form = $formFactory->createForm();
        $form->setData($user);
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN') || $id_user == 1 ) {
            $form->remove('roles');
        } else {
            $form->get('roles')->setData($user->getRoles()[0]);
        }

        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var $userManager UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);
            if ($this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
                $newRole = $form["roles"]->getData();
                $user->setRoles(array($newRole));
            }
            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_profile_show', array('id'=> $id_user));
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }


        return $this->render('FOSUserBundle:Profile:edit.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
    }

    /**
     * Disable the user.
     *
     * @param Request $request
     *
     * @return bool true if user was disabled, false otherwise
     */

    public function disableAction(Request $request)
    {   
        $id_user = intval($request->get('id'));
        $user = $this->getDestinationUserObject($id_user);
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        if ($user->isEnabled()) {
            $user->setEnabled(false);
        } else {
            $user->setEnabled(true);
        }

        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        
        $userManager->updateUser($user);
        $event = new UserEvent($user, $this->getRequest());
        $dispatcher->dispatch(FOSUserEvents::USER_DEACTIVATED, $event);
        return $this->redirectToRoute("admin_users_index");
    }
    

    private function getDestinationUserObject($id_user){
        $user = null;
        if ($id_user == 0){
            $user = $this->getUser();
        } else {
            $em = $this->getDoctrine()->getManager();
            if ($this->getUser()->getId() != $id_user){
                $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', $this->getUser(), 'No tiene permisos para ingresar a esta página!');
            }
            $user = $em->getRepository('AppBundle:Usuarios')->findOneById($id_user);
        }
        return $user;
    }
}