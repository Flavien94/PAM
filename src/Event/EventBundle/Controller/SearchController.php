<?php

namespace Event\EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Event\EventBundle\Entity\Event;
use Event\EventBundle\Form\EventType;
use Event\EventBundle\Entity\Search;
use Event\EventBundle\Form\SearchType;


class SearchController extends Controller
{
  /**
   * Lists all search entities.
   *
   * @Route("/", name="search")
   * @Method("GET")
   * @Template()
   */
    public function searchAction(Request $request)
    {
      $search = $request->query->get('query');
      // $dateStart = $request->query->get('beginning');
      // dump($dateStart);
         $em = $this->getDoctrine()->getManager();

         $sql = 'SELECT id, date_start, date_end, title, description, image_id FROM event
         WHERE MATCH (title, description, contact_name) AGAINST ("'.$search.'* " IN BOOLEAN MODE)';
         //
        //  if($dateStart != null) {
        //    $sql = $sql . ' AND date_start = '.$dateStart.' ';
        //  }
         //
        //  $sql = $sql . ';';

         $query = $em->getConnection()->prepare($sql);
         $query->execute();

         $events = $query->fetchAll();

         $search = new Search();
         $formSearch = $this->createSearchForm($search);
         $formSearch->handleRequest($request);

         if ($formSearch->isValid()) {
             $em = $this->getDoctrine()->getManager();
             $em->persist($search);
             $em->flush();

         }

         return $this->render('EventBundle:Event:search.html.twig', [ "events" => $events,
         'form'   => $formSearch->createView()
       ]);
    }

    /**
     * Creates a form to create a Search entity.
     *
     * @param Event $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createSearchForm(Search $search)
    {
        $formSearch = $this->createForm(new SearchType(), $search, array(
            'action' => $this->generateUrl('event_create'),
            'method' => 'GET',
        ));

        $formSearch->add('submit', 'submit', array('label' => 'Chercher'));

        return $formSearch;
    }

  }
