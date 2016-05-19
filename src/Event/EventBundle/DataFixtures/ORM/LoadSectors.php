<?php
namespace Event\EventBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Event\EventBundle\Entity\Sector;

class LoadSector implements FixtureInterface
{
  function load(ObjectManager $manager)
  {
    $sectors = array(
      array(
        'caption' => 'A',
        'titles' => 'Agriculture et pêche, espaces naturels et espaces verts, soins aux animaux'
       ),
       array(
         'caption' => 'B',
         'titles' => 'Arts et façonnage d\'œuvrages d\'arts'
       ),
       array(
         'caption' => 'C',
         'titles' => 'Banque, Assurance, Immobilier'
       ),
       array(
         'caption' => 'D',
         'titles' => 'Commerce, Vente et Grande Distribution'
       ),
       array(
         'caption' => 'E',
         'titles' => 'Communication, Média et Multimédia'
       ),
       array(
         'caption' => 'F',
         'titles' => 'Construction, Bâtiment et Travaux Publics'
       ),
       array(
         'caption' => 'G',
         'titles' => 'Hôtellerie-Restauration Tourisme Loisirs et Animation'
       ),
       array(
         'caption' => 'H',
         'titles' => 'Industrie'
       ),
       array(
         'caption' => 'I',
         'titles' => 'Installation et Maintenance'
       ),
       array(
         'caption' => 'J',
         'titles' => 'Santé'
       ),
       array(
         'caption' => 'K',
         'titles' => 'Service à la personne et à la collectivité'
       ),
       array(
         'caption' => 'L',
         'titles' => 'Spectacle'
       ),
       array(
         'caption' => 'M',
         'titles' => 'Support à l\'entreprise'
       ),
       array(
         'caption' => 'N',
         'titles' => 'Transport et Logistique'
       ),
       array(
         'caption' => 'TOUT SECTEURS',
         'titles' => 'Tout secteurs'
       )
    );

    for($i = 0; $i < count($sectors); $i++) {
      $new = new Sector();
      $new->setTitle($sectors[$i]["titles"]);
      $new->setCaption($sectors[$i]["caption"]);

      $manager->persist($new);
    }

    $manager->flush();
  }
}
