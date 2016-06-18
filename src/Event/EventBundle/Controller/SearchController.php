<?php

namespace Event\EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Event\EventBundle\Entity\Event;
use Event\EventBundle\Entity\Images;
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



           $sql = 'SELECT event.id, date_start, date_end, title, description, contact_name, scratch, city, cp, url FROM event JOIN place ON (event.place_id = place.id) LEFT JOIN images ON (event.image_id = images.id) WHERE scratch = 0 ';

           $whereIsSet = false;

         if($search != null) {
           $sql = $sql . ' AND MATCH (city, cp, title, description, contact_name ) AGAINST ("'.$search.'*" IN BOOLEAN MODE)';
           }

         if($dateStart != null) {
             $sql = $sql . ' AND date_start >= "'.$dateStart.'"';
           }


         if($dateEnd != null) {
             $sql = $sql . ' AND date_end <= "'.$dateEnd.'"';
           }


         if($sectors != null) {
             $sql = $sql . ' AND sector_id = "'.$sectors.'"';
           }

         if($publics != null) {
             $sql = $sql . ' AND publics_id = "'.$publics.'"';
           }

         if($types != null) {
             $sql = $sql . ' AND type_id = "'.$types.'"';
           }
         

         if( $search == "" && $dateStart == "" && $dateEnd == "" && $sectors == "" && $publics == "" && $types == "" ) {
           $sql = ' SELECT event.id, date_start, date_end, title, description, contact_name, scratch, city, cp, url FROM event JOIN place ON (event.place_id = place.id) LEFT JOIN images ON (event.image_id = images.id)  WHERE  date_start > CURDATE() AND scratch = 0' ;
             }

         $sql = $sql . ' ORDER BY date_start ASC LIMIT 10 ;';

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
