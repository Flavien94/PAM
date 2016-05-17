<?php
namespace Event\EventBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Event\EventBundle\Entity\Type;

class LoadType implements FixtureInterface
{
  function load(ObjectManager $manager)
  {
    $titles = array(
      'Accompagnement',
      'AFC',
      'Atelier',
      'Association',
      'Commissions',
      'Concours',
      'Formation',
      'Forum',
      'Info-co',
      'Recrutements'
    );

    foreach ($titles as $title) {
      $type = new Type();
      $type->setTitle($title);

      $manager->persist($type);
    }

    $manager->flush();
  }
}
