<?php

namespace Event\EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Event\EventBundle\Entity\Event;
use Event\EventBundle\Form\EventType;


class SearchController extends Controller
{
  /**
   * Lists all search entities.
   *
   * @Route("/search", name="search")
   * @Method("GET")
   * @Template()
   */
    // public function searchActionOld(Request $request)
    // {
    //   $search = $request->query->get('query');
    //      $em = $this->getDoctrine()->getManager();
    //
    //      $sql = 'SELECT id, date_start, date_end, title, description FROM event WHERE MATCH (title, description, contact_name) AGAINST ("'.$search.'" IN NATURAL LANGUAGE MODE)';
    //
    //      $query = $em->getConnection()->prepare($sql);
    //      $query->execute();
    //
    //      $events = $query->fetchAll();
    //
    //      //$posts = $query->getResult();
    //
    //
    //      return $this->render('EventBundle:Event:search.html.twig', [ "events" => $events]);
    // }

    public function searchAction($query) {
    return $this->createQueryBuilder('p')
        ->addSelect("MATCH_AGAINST (p.id, p.date_start, p.date_end, p.title, p.description, :query 'IN NATURAL MODE') as score")
        ->add('where', 'MATCH_AGAINST(p.title, p.description, p.contact_name, :query) > 0.8')
        ->setParameter('query', $query)
        ->orderBy('score', 'desc')
        ->setMaxResults(5)
        ->getQuery()
        ->getResult();
}
}
