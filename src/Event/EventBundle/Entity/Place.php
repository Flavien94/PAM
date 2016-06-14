<?php

namespace Event\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Place
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Place
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="adress_1", type="string", length=255, nullable=true)
     * @Assert\Length(min=2, minMessage="Adresse 1 : Ce champs doit contenir au minimun 2 caractères")
     */
    private $adress1;

    /**
     * @var string
     *
     * @ORM\Column(name="adress_2", type="string", length=255, nullable=true)
     * @Assert\Length(min=2, minMessage="Adresse 2 : Ce champs doit contenir au minimun 2 caractères")
     */
    private $adress2;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=false)
     * @Assert\Length(min=2, minMessage="Ville : Ce champs doit contenir au minimun 2 caractères")
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="cp", type="string", length=255, nullable=false)
     * @Assert\Length(min=2, minMessage="CP : Ce champs doit contenir au minimun 2 caractères")
     */
    private $cp;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255, nullable=false)
     * @Assert\Length(min=2, minMessage="Lieux : Ce champs doit contenir au minimun 2 caractères")
     */
    private $country;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set adress1
     *
     * @param string $adress1
     *
     * @return Place
     */
    public function setAdress1($adress1)
    {
        $this->adress1 = $adress1;

        return $this;
    }

    /**
     * Get adress1
     *
     * @return string
     */
    public function getAdress1()
    {
        return $this->adress1;
    }

    /**
     * Set adress2
     *
     * @param string $adress2
     *
     * @return Place
     */
    public function setAdress2($adress2)
    {
        $this->adress2 = $adress2;

        return $this;
    }

    /**
     * Get adress2
     *
     * @return string
     */
    public function getAdress2()
    {
        return $this->adress2;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Place
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set cp
     *
     * @param string $cp
     *
     * @return Place
     */
    public function setCp($cp)
    {
        $this->cp = $cp;

        return $this;
    }

    /**
     * Get cp
     *
     * @return string
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Place
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }
}
