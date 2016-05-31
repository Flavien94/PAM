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
    public function searchAction(Request $request)
    {
      $search = $request->query->get('query');
         $em = $this->getDoctrine()->getManager();

         $sql = 'SELECT id, date_start, date_end, title, description FROM event WHERE MATCH (title, description, contact_name) AGAINST ("'.$search.'" IN NATURAL LANGUAGE MODE)';
         //
        //  if() {
        //    $sql = $sql . ' AND ';
         //
        //  }
         //
        //  $sql = $sql . ';';

         $query = $em->getConnection()->prepare($sql);
         $query->execute();

         $events = $query->fetchAll();

         //$posts = $query->getResult();


         return $this->render('EventBundle:Event:search.html.twig', [ "events" => $events]);
    }
}

/**
 * Creates a new Event entity.
 *
 * @Route("/", name="event_search")
 * @Method("GET")
 * @Template("app:Resources:views:modules:header.html.twig")
 */
public function eventSearchAction(Request $request)
{
    $event = new Event();
    $form = $this->createCreateForm($event);
    $form->handleRequest($request);

    if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($event);
        $em->flush();

        return $this->redirect($this->generateUrl('event_show', array('id' => $event->getId())));
    }
    return array(
        'entity' => $event,
        'form'   => $form->createView(),
    );
}
