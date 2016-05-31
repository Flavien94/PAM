<?php

namespace Event\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Search
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Search
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
     * @var \DateTime
     *
     * @ORM\Column(name="date_start", type="datetime")
     */
    private $dateStart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_end", type="datetime")
     */
    private $dateEnd;

    /**
    * @ORM\ManyToMany(targetEntity="Event\EventBundle\Entity\Sector", cascade={"persist"})
    */
    private $sector;
    /**
    * @ORM\ManyToMany(targetEntity="Event\EventBundle\Entity\Publics", cascade={"persist"})
    */
    private $publics;
    /**
    * @ORM\ManyToMany(targetEntity="Event\EventBundle\Entity\Type", cascade={"persist"})
    */
    private $type;

    public function __construct()
    {
      $this->sector = new ArrayCollection();
      $this->publics = new ArrayCollection();
      $this->type = new ArrayCollection();
    }
    public function __toString(){
      return (string) $this->getPublics();
      return (string) $this->getSector();
    }
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
     * Set dateStart
     *
     * @param \DateTime $dateStart
     *
     * @return Search
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * Get dateStart
     *
     * @return \DateTime
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     *
     * @return Search
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return \DateTime
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * Set sector
     *
     * @param string $sector
     *
     * @return Search
     */
    public function setSector($sector)
    {
        $this->sector[] = $sector;

        return $this;
    }

    /**
     * Get sector
     *
     * @return string
     */
    public function getSector()
    {
        return $this->sector;
    }

    /**
     * Set publics
     *
     * @param string $publics
     *
     * @return Search
     */
    public function setPublics($publics)
    {
        $this->publics = $publics;

        return $this;
    }

    /**
     * Get publics
     *
     * @return string
     */
    public function getPublics()
    {
        return $this->publics;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Search
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
