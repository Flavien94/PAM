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
        'titles' => ' A - Agriculture et pêche, espaces naturels et espaces verts, soins aux animaux'
       ),
       array(
         'caption' => 'B',
         'titles' => 'B - Arts et façonnage d\'œuvrages d\'arts'
       ),
       array(
         'caption' => 'C',
         'titles' => 'C - Banque, Assurance, Immobilier'
       ),
       array(
         'caption' => 'D',
         'titles' => 'D - Commerce, Vente et Grande Distribution'
       ),
       array(
         'caption' => 'E',
         'titles' => 'E - Communication, Média et Multimédia'
       ),
       array(
         'caption' => 'F',
         'titles' => 'F - Construction, Bâtiment et Travaux Publics'
       ),
       array(
         'caption' => 'G',
         'titles' => 'G - Hôtellerie-Restauration Tourisme Loisirs et Animation'
       ),
       array(
         'caption' => 'H',
         'titles' => 'H - Industrie'
       ),
       array(
         'caption' => 'I',
         'titles' => 'I - Installation et Maintenance'
       ),
       array(
         'caption' => 'J',
         'titles' => 'J - Santé'
       ),
       array(
         'caption' => 'K',
         'titles' => 'K - Service à la personne et à la collectivité'
       ),
       array(
         'caption' => 'L',
         'titles' => 'L - Spectacle'
       ),
       array(
         'caption' => 'M',
         'titles' => 'M - Support à l\'entreprise'
       ),
       array(
         'caption' => 'N',
         'titles' => 'N - Transport et Logistique'
       ),
       array(
         'caption' => 'TOUT SECTEUR',
         'titles' => 'Tout secteur'
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
