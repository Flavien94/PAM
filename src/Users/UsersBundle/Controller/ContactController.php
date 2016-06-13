<?php

namespace Users\UsersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ContactController extends Controller {

    public function contactAction(Request $request) {
      $em = $this->getDoctrine()->getEntityManager();
      $connection = $em->getConnection();
      $statement = $connection->prepare("SELECT id, firstname, lastname, email, object, message FROM contact");
      $statement->execute();
      $results = $statement->fetchAll();
      dump($results);
      return $this->render('UsersBundle:Default:contact.html.twig', array('contacts' => $results ));
    }
    /**
     * Finds and displays a Event entity.
     *
     * @Route("/contact_show/{id}", name="contact_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
      dump('bonjour');
      $em = $this->getDoctrine()->getEntityManager();
      $connection = $em->getConnection();
      $statement = $connection->prepare("SELECT id, firstname, lastname, email, object, message FROM contact WHERE id = $id");
      $statement->execute();
      $results = $statement->fetchAll();
      dump($results);
      return $this->render('UsersBundle:Default:show.html.twig', array('contacts' => $results ));
    }
    /**
    * @Route(
    *    path          = "/contact_delete/{id}",
    *    name          = "contact_delete",
    *    methods       = { "GET" },
    * )
    */
   public function deleteAction($id) {
     $em = $this->getDoctrine()->getManager();

     /** @var \Star9988\ModelBundle\Entity\User $user */
     $user = $this->getDoctrine()->getRepository('UsersBundle:Users')->find($id);

     $em->remove($user);
     $em->flush();

     return new RedirectResponse($this->generateUrl('list'));
   }
}
