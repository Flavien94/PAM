<?php

namespace Waiting\WaitingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WaitController extends Controller
{
    public function indexAction()
    {
        return $this->render('WaitingBundle:Default:wait.html.twig');
    }
}
