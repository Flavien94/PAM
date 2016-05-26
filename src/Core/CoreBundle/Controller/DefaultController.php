<?php

namespace Core\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    public function indexAction()
    {
      $em = $this ->getDoctrine()
                  ->getManager();

      $events = $em ->createQueryBuilder()
                    ->select('b')
                    ->from('EventBundle:Event',  'b')
                    ->where('b.dateEnd > :now')
                    ->setParameter('now', new \DateTime('now'))
                    ->addOrderBy('b.dateStart', 'ASC')
                    ->getQuery()
                    ->getResult();
                    // classer d'abord headline et ensuite par date state




        return $this->render('CoreBundle:Default:index.html.twig', array(
            'events' => $events,
        ));
    }
}
