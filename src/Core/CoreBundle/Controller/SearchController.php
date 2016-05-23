<?php

namespace Core\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CoreBundle:Default:index.html.twig');
    }
}




/*Code de Guillaume 

$search = $request->query->get('search');

     $em = $this->getDoctrine()->getManager();
     $sql = 'SELECT * FROM posts WHERE MATCH (title, url) AGAINST ("'.$search.'" IN BOOLEAN MODE)';

     $query = $em->getConnection()->prepare($sql);
     $query->execute();

     $posts = $query->fetchAll();

     return $this->render('@App/posts/index.html.twig', [ "posts" => $posts]);
