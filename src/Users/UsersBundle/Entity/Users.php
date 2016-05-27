<?php

namespace Users\UsersBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 *
 *
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="email",
 *          column=@ORM\Column(
 *              type =  "string",
 *              name     = "email",
 *              nullable = true,
 *              unique   = true
 *          )
 *      ),
 *      @ORM\AttributeOverride(name="emailCanonical",
 *          column=@ORM\Column(
 *              type = "string",
 *              name     = "email_canonical",
 *              nullable = true,
 *              unique   = true
 *          )
 *      )
 * })
 *
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
       $this->setEmail(null);
   }
   public function __construct()
   {
       parent::__construct();

  }
}
