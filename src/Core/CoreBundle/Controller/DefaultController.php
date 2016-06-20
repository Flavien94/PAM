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
                    ->andwhere('b.scratch = 0')
                    ->setParameter('now', new \DateTime('now'))
                    ->addOrderBy('b.dateStart', 'ASC')
                    ->getQuery()
                    ->getResult();

                    $sql = ' SELECT COUNT(id) FROM contact ' ;
                    $query = $em->getConnection()->prepare($sql);
                    $query->execute();
                    $notif = $query->fetchAll();
                    for ($i=0; $i < count($notif); $i++) {
                       $notification = $notif[$i];
                    }

        return $this->render('CoreBundle:Default:index.html.twig', array(
            'events' => $events,
            'notif' => $notification
        ));
    }

    public function notificationAction($max = 3)
    {
        // make a database call or other logic
        // to get the "$max" most recent articles
        $em = $this ->getDoctrine()
                    ->getManager();

                    $sql = ' SELECT COUNT(id) FROM contact WHERE seen = 0 ';
                    $query = $em->getConnection()->prepare($sql);
                    $query->execute();
                    $notif = $query->fetchAll();
                    for ($i=0; $i < count($notif); $i++) {
                       $notification = $notif[$i];
                    }
        return $this->render(
            'CoreBundle:Default:notification.html.twig',
            array('notifs' => $notification)
        );
    }
}
