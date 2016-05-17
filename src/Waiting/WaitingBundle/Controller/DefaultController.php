<?php

namespace Waiting\WaitingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('WaitingBundle:Default:index.html.twig');
    }
}
