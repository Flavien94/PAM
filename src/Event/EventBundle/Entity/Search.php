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
     * @var \Date
     *
     * @ORM\Column(name="date_start", type="date", nullable=true)
     */
    private $dateStart;
    /**
     * @var \Time
     *
     * @ORM\Column(name="time_start", type="time", nullable=true)
     */
    private $timeStart;

    /**
     * @var \Date
     *
     * @ORM\Column(name="date_end", type="date", nullable=true)
     */
    private $dateEnd;
    /**
     * @var \Time
     *
     * @ORM\Column(name="time_end", type="time", nullable=true)
     */
    private $timeEnd;
    /**
    * @ORM\ManyToOne(targetEntity="Event\EventBundle\Entity\Sector", cascade={"persist"})
    * @ORM\JoinColumn(nullable=true)
    */
    private $sector;
    /**
    * @ORM\ManyToOne(targetEntity="Event\EventBundle\Entity\Publics", cascade={"persist"})
    * @ORM\JoinColumn(nullable=true)
    */
    private $publics;
    /**
    * @ORM\ManyToOne(targetEntity="Event\EventBundle\Entity\Type", cascade={"persist"})
    * @ORM\JoinColumn(nullable=true)
    */
    private $type;

    // public function __construct()
    // {
    //   // $this->sector = new ArrayCollection();
    //   // $this->publics = new ArrayCollection();
    //   // $this->type = new ArrayCollection();
    // }
    public function __toString(){
      return (string) $this->getPublics();
      return (string) $this->getSector();
      return (string) $this->getDateStart();
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
     * @param \Date $dateStart
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
     * @return \Date
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }
    /**
     * Set timeStart
     *
     * @param \Time $timeStart
     *
     * @return Search
     */
    public function setTimeStart($timeStart)
    {
        $this->timeStart = $timeStart;

        return $this;
    }

    /**
     * Get timeStart
     *
     * @return \Time
     */
    public function getTimeStart()
    {
        return $this->timeStart;
    }

    /**
     * Set dateEnd
     *
     * @param \Date $dateEnd
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
     * @return \Date
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }
    /**
     * Set timeEnd
     *
     * @param \Time $timeEnd
     *
     * @return Search
     */
    public function setTimeEnd($timeEnd)
    {
        $this->timeEnd = $timeEnd;

        return $this;
    }

    /**
     * Get timeEnd
     *
     * @return \Time
     */
    public function getTimeEnd()
    {
        return $this->timeEnd;
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
        $this->sector= $sector;

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
