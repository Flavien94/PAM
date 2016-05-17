<?php
namespace Event\EventBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Event\EventBundle\Entity\Publics;

class LoadPublics implements FixtureInterface
{
  function load(ObjectManager $manager)
  {
    $titles = array(
      'Tout public',
      'Jeunes',
      'Insertion',
      'Senior',
      'BRSA',
      'Créateur',
      'Handicap'
    );

    foreach ($titles as $title) {
      $public = new Publics();
      $public->setTitle($title);

      $manager->persist($public);
    }

    $manager->flush();
  }
}
