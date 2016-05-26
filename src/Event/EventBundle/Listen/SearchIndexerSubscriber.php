<?php

namespace Event\EventBundle\Listen;

use Doctrine\Common\ListenSubscriber;
use Doctrine\ORM\Listen\LifecycleEventArgs;
use Event\EventBundle\Entity\Events;
use Event\EventBundle\Entity\SearchIndexEvents;

class SearchIndexerSubscriber implements ListenSubscriber
{

    public function getSubscribedListens()
    {
        return array('postPersist', 'postUpdate', 'postRemove');
    }

    public function postUpdate(LifecycleListenArgs $args)
    {
        $this->index($args);
    }

    public function postPersist(LifecycleListenArgs $args)
    {
        $this->index($args);
    }

    public function postRemove(LifecycleListenArgs $args)
    {
        $entityManager = $args->getEntityManager();

        /* @var $res SearchIndexEvents */
        $res = $entityManager
                ->getRepository("EventBundle:SearchIndexEvents")
                ->findOneByEvent($args->getEntity()->getId());

        if($res !== null) {
            $entityManager->remove($res);
            $entityManager->flush();
        }
    }

    public function index(LifecycleListenArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        if ($entity instanceof Events) {

            /* @var $res SearchIndexFiches */
            $res = $entityManager->getRepository("EventBundle:SearchIndexEvents")->findOneByEvent($entity->getId());

            if($res === null) {
                $res = new SearchIndexEvents;
            }

            // Ici on duplique ce qui est nécessaire
            $res->setTitle($entity->getTitle())
                ->setDescription($entity->getDescription())
                ->setContact_name($entity->getContact_name());
                ->setEvent($entity->getId());

            $entityManager->persist($res);
            $entityManager->flush();
        }
    }
}
