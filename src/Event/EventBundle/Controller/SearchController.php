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
      $dateStart = $request->query->get('event_eventbundle_search')['dateStart'];
      $dateEnd = $request->query->get('event_eventbundle_search')['dateEnd'];
      $sectors = $request->query->get('event_eventbundle_search')['sector'];
      $publics = $request->query->get('event_eventbundle_search')['publics'];
      $types = $request->query->get('event_eventbundle_search')['type'];
      $errorMessage = "Aucun événement ne correspond à votre recherche.";
         $em = $this->getDoctrine()->getManager();


           $sql = 'SELECT id, date_start, date_end, title, description, image_id, sector_id, publics_id, type_id FROM event ';

           $whereIsSet = false;

         if($search != null) {
           if(!$whereIsSet) {
            $sql = $sql .' WHERE MATCH (title, description, contact_name) AGAINST ("'.$search.'*" IN BOOLEAN MODE)';
             $whereIsSet = true;
           } else {
             $sql = $sql . ' AND MATCH (title, description, contact_name) AGAINST ("'.$search.'*" IN BOOLEAN MODE)';
           }
         }

         if($dateStart != null) {
           if(!$whereIsSet) {
            $sql = $sql .' WHERE date_start >= "'.$dateStart.'"';
             $whereIsSet = true;
           } else {
             $sql = $sql . ' AND date_start >= "'.$dateStart.'"';
           }
         }

         if($dateEnd != null) {
           if(!$whereIsSet) {
            $sql = $sql .' WHERE date_end <= "'.$dateEnd.'"';
             $whereIsSet = true;
           } else {
             $sql = $sql . ' AND date_end <= "'.$dateEnd.'"';
           }
         }

         if($sectors != null) {
           if(!$whereIsSet) {
            $sql = $sql .' WHERE sector_id = "'.$sectors.'"';
             $whereIsSet = true;
           } else {
             $sql = $sql . ' AND sector_id = "'.$sectors.'"';
           }
         }
         if($publics != null) {
           if(!$whereIsSet) {
            $sql = $sql .' WHERE publics_id = "'.$publics.'"';
             $whereIsSet = true;
           } else {
             $sql = $sql . ' AND publics_id = "'.$publics.'"';
           }
         }
         if($types != null) {
           if(!$whereIsSet) {
            $sql = $sql .' WHERE type_id = "'.$types.'"';
             $whereIsSet = true;
           } else {
             $sql = $sql . ' AND type_id = "'.$types.'"';
           }
         }




         $sql = $sql . ' LIMIT 10;';


         $query = $em->getConnection()->prepare($sql);
         $query->execute();

         $events = $query->fetchAll();
         $queryvalue = $search;
         $search = new Search();

         $formSearch = $this->createSearchForm($search);
         $formSearch->handleRequest($request);

         if ($formSearch->isValid()) {
             $em = $this->getDoctrine()->getManager();
             $em->persist($search);
             $em->flush();

         }

         return $this->render('EventBundle:Event:search.html.twig', [
          "events" => $events,
         'queryvalue' => $queryvalue,
         'errorMessage' => $errorMessage,
         'formSearch'   => $formSearch->createView(),
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
