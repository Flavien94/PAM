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
   * @Route("/{page}", name="search")
   * @Method("GET")
   * @Template()
   */
    public function searchAction(Request $request)
    {
      $PAGE_LENGTH = 10;
      $search = $request->query->get('query');
      $page = intval($request->query->get('page'));
      if($page < 1) $page = 1;
      $dateStart = $request->query->get('event_eventbundle_search')['dateStart'];
      $dateEnd = $request->query->get('event_eventbundle_search')['dateEnd'];
      $sectors = $request->query->get('event_eventbundle_search')['sector'];
      $publics = $request->query->get('event_eventbundle_search')['publics'];
      $types = $request->query->get('event_eventbundle_search')['type'];
      $errorMessage = "Aucun événement ne correspond à votre recherche.";
         $em = $this->getDoctrine()->getManager();

           $sql = 'SELECT event.id, date_start, date_end, title, description, contact_name, scratch, city, cp, url FROM event JOIN place ON (event.place_id = place.id) LEFT JOIN images ON (event.image_id = images.id) WHERE scratch = 0 ';
           $countSql = 'SELECT COUNT(*) as count FROM event JOIN place ON (event.place_id = place.id) WHERE scratch = 0 ';


         if($search != null) {
           $sql = $sql . ' AND MATCH (city, cp, title, description, contact_name ) AGAINST ("'.$search.'*" IN BOOLEAN MODE)';
           $countSql = $countSql . ' AND MATCH (city, cp, title, description, contact_name ) AGAINST ("'.$search.'*" IN BOOLEAN MODE)';
           }

         if($dateStart != null) {
             $sql = $sql . ' AND date_start >= "'.$dateStart.'"';
             $countSql = $countSql . ' AND date_start >= "'.$dateStart.'"';
           }


         if($dateEnd != null) {
             $sql = $sql . ' AND date_end <= "'.$dateEnd.'"';
             $countSql = $countSql . ' AND date_end <= "'.$dateEnd.'"';
           }
           else {
             $sql = $sql . ' AND date_end > CURDATE()';
             $countSql = $countSql . ' AND date_end > CURDATE()';
           }


         if($sectors != null) {
             $sql = $sql . ' AND sector_id = "'.$sectors.'"';
             $countSql = $countSql . ' AND sector_id = "'.$sectors.'"';
           }

         if($publics != null) {
             $sql = $sql . ' AND publics_id = "'.$publics.'"';
             $countSql = $countSql . ' AND publics_id = "'.$publics.'"';
           }

         if($types != null) {
             $sql = $sql . ' AND type_id = "'.$types.'"';
             $countSql = $countSql . ' AND type_id = "'.$types.'"';
           }


         $sql = $sql . ' ORDER BY date_start ASC';
         $sql = $sql . ' LIMIT ' . $PAGE_LENGTH;
         $sql = $sql . ' OFFSET ' . ($page - 1) * $PAGE_LENGTH . ';';
         $countSql = $countSql . ';';
         $query = $em->getConnection()->prepare($sql);
         $query->execute();

         $queryCount = $em->getConnection()->prepare($countSql);
         $queryCount->execute();
         $count = $queryCount->fetch()["count"];
         $nbPage = ceil($count / $PAGE_LENGTH)  ;

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
         'page' => $page,
         'count' => $count,
         'nbPage' => $nbPage,
         'PAGE_LENGTH' => $PAGE_LENGTH,
         'events' => $events,
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
