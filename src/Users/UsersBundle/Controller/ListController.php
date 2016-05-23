<?php

namespace Users\UsersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ListController extends Controller {

    public function indexAction() {

      $userManager = $this->get('fos_user.user_manager');
      $users = $userManager->findUsers();

      return $this->render('UsersBundle:Default:list.html.twig', array('users' =>   $users));
    }

}
