<?php

namespace Event\EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SearchController extends Controller
{
    public function searchAction()
    {

            $qb = $this ->getDoctrine()
                         ->getManager();

            $events = $qb ->createQueryBuilder()
                            ->select("b")
                            ->from('EventBundle:Event',  "b")
                            ->andWhere('MATCH (b.title, b.description, b.contact_name, :textFilter "IN NATURAL LANGUAGE MODE WITH QUERY EXPANSION") AGAINST (b.titre, b.description, b.contact_name, :textFilter "IN NATURAL LANGUAGE MODE WITH QUERY EXPANSION") > 0.8')
                            ->setParameter("textFilter", 'value')
              ;
                      return $this->render('EventBundle:Event:search.html.twig', array(
                          'events' => $events,
                            ));
    }
}
