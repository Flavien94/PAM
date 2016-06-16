<?php

namespace Users\UsersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('UsersBundle:Default:index.html.twig', array('name' => $name));
    }
    public function changepasswordAction()
    {
        return $this->render('UsersBundle:Default:changepassword.html.twig');
    }
}
