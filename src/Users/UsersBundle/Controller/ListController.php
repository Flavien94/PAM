<?php

namespace Users\UsersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ListController extends Controller {

    public function indexAction() {
      $userManager = $this->get('fos_user.user_manager');
      $user = $userManager->findUsers();
      return $this->render('UsersBundle:Default:list.html.twig', array('users' =>   $user));
    }

    /**
     * Finds and displays a Event entity.
     *
     * @Route("/list/update/{id}", name="list_update")
     * @Method("GET")
     * @Template()
     */
    public function updateAction(Request $request, $id) {
      /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
      $userManager = $this->get('fos_user.user_manager');
      $user = $userManager->findUserBy(array('id'=>$id));

      if (!is_object($user) || !$user instanceof UserInterface) {
          throw new AccessDeniedException('This user does not have access to this section.');
      }

      /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
      $dispatcher = $this->get('event_dispatcher');

      $event = new GetResponseUserEvent($user, $request);
      $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_INITIALIZE, $event);

      if (null !== $event->getResponse()) {
          return $event->getResponse();
      }

      /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
      $formFactory = $this->get('fos_user.change_password.form.factory');

      $form = $formFactory->createForm();
      $form->setData($user);

      $form->handleRequest($request);

      if ($form->isValid()) {

          $event = new FormEvent($form, $request);
          $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_SUCCESS, $event);

          $userManager->updateUser($user);
          $this->get('session')->getFlashBag()->add('success', 'Le mot de passe a bien été modifié.');
          return $this->redirectToRoute('list_update',array(
            'id' => $id
          ));
      }
      return $this->render('FOSUserBundle:ChangePassword:changePassword.html.twig', array(
          'user' => $user,
          'form' => $form->createView()
      ));
    }
}
