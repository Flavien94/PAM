<?php

namespace Users\UsersBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="users")
*/
class Users extends BaseUser
{

   /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue(strategy="AUTO")
    */
   protected $id;

   public function setUsername($username){
       parent::setUsername($username);
       $this->setEmail($username.'@pam-pepaca.fr');
   }
   public function __construct()
   {
       parent::__construct();

  }
}
