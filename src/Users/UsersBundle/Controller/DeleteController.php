<?php

namespace Users\UsersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
class DeleteController extends Controller {

  /**
  * @Route(
  *    path          = "/delete/{id}",
  *    name          = "delete",
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
