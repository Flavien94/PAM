<?php

namespace Event\EventBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Event\EventBundle\Entity\Event;
use Event\EventBundle\Form\EventType;
use Event\EventBundle\Entity\Search;
use Event\EventBundle\Form\SearchType;
use Event\EventBundle\Entity\FileEvent;
use Event\EventBundle\Entity\Links;
use Event\EventBundle\Entity\Images;

/**
 * Event controller.
 *
 * @Route("/event")
 */
class EventController extends Controller
{

    /**
     * Lists all Event entities.
     *
     * @Route("/", name="event")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EventBundle:Event')->findAll();

        $q = $em->createQueryBuilder()
                      ->select('b')
                      ->from('EventBundle:Event',  'b');


        $entities = $em->createQueryBuilder()
                      ->select('b')
                      ->from('EventBundle:Event',  'b')
                      ->where('b.dateEnd > :now')
                      ->andwhere('b.scratch = 0')
                      ->setParameter('now', new \DateTime('now'))
                      ->addOrderBy('b.dateStart', 'ASC')
                      ->getQuery()
                      ->getResult();


                      $search = new Search();
                      $formSearch = $this->createSearchForm($search);
                      $formSearch->handleRequest($request);

                      if ($formSearch->isValid()) {
                          $em = $this->getDoctrine()->getManager();
                          $em->persist($search);
                          $em->flush();
                          return $this->redirect($this->generateUrl('search', array('id' => $entity->getId())));
                      }


        return array(
            'entities' => $entities,
            'formSearch'   => $formSearch->createView(),
        );
    }
    /**
     * Creates a new Event entity.
     *
     * @Route("/", name="event_create")
     * @Method("POST")
     * @Template("EventBundle:Event:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Event();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if($entity->getHeadlines() == true){
              $queryOldHL= $em->createQuery('UPDATE EventBundle:Event e SET e.headlines = 0 WHERE e.headlines = 1');
              $query = $queryOldHL->getResult();
            }
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('event_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Event entity.
     *
     * @param Event $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Event $entity)
    {
        $form = $this->createForm(new EventType(), $entity, array(
            'action' => $this->generateUrl('event_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
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
    /**
     * Displays a form to create a new Event entity.
     *
     * @Route("/new", name="event_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Event();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Event entity.
     *
     * @Route("/{id}", name="event_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EventBundle:Event')->find($id);
        $author = $entity->getAuthor();
        $scratch = $entity->getScratch();
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!$entity) {
          throw $this->createNotFoundException('Unable to find Event entity.');
        }
        if ($user === 'anon.' AND $scratch === true) {
          return $this->redirectToRoute('event');
        }
        if ($user != 'anon.' AND $scratch === true) {
          $username = $user->getUsername();
          if ($author != $username) {
            return $this->redirectToRoute('event');
          }
        }
        $deleteForm = $this->createDeleteForm($id);
        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Event entity.
     *
     * @Route("/{id}/edit", name="event_edit")
     * @ParamConverter("edit_event", class="EventBundle:Event")
     * @Method({"GET","POST"})
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EventBundle:Event')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Event entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Event entity.
    *
    * @param Event $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Event $entity)
    {
        $form = $this->createForm(new EventType(), $entity, array(
            'action' => $this->generateUrl('event_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Mettre à jour'));

        return $form;
    }
    /**
     * Edits an existing Event entity.
     *
     * @Route("/{id}", name="event_update")
     * @Method("PUT")
     * @Template("EventBundle:Event:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EventBundle:Event')->find($id);
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Event entity.');
        }

        if ($editForm->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($entity);
          $em->flush();

          return $this->redirect($this->generateUrl('event_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,

            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Event entity.
     *
     * @Route("/{id}", name="event_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EventBundle:Event')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Event entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('search'));
    }

    /**
     * Creates a form to delete a Event entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('event_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer'))
            ->getForm()
        ;
    }
    /**
     * @Route("/myevent", name="myevent")
     * @Method("GET")
     * @Template()
     */
    public function myeventAction(Request $request)
    {
      $user = $this->container->get('security.context')->getToken()->getUser()->getUsername();
      $em = $this->getDoctrine()->getManager();
      $entities = $em->getRepository('EventBundle:Event')->findAll();
      $entities = $em->createQueryBuilder()
                    ->select('b')
                    ->from('EventBundle:Event',  'b')
                    ->where('b.author = :user ')
                    ->setParameter('user', $user)
                    ->addOrderBy('b.dateStart', 'ASC')
                    ->getQuery()
                    ->getResult();
        return array(
            'entities' => $entities
        );
    }
    /**
    * @Route(
    *    path          = "/mydelete/{id}",
    *    name          = "myevent_delete",
    *    methods       = { "GET" },
    * )
    */
   public function mydeleteAction($id) {

         $em = $this->getDoctrine()->getManager();
         $entity = $em->getRepository('EventBundle:Event')->find($id);

         if (!$entity) {
             throw $this->createNotFoundException('Unable to find Event entity.');
         }

         $em->remove($entity);
         $em->flush();

     return $this->redirect($this->generateUrl('search'));
   }

}
