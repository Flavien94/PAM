<?php

namespace Event\EventBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * Event
 *
 * @ORM\Table(name="event",options={"engine"="MyISAM"}, indexes={@ORM\Index(columns={"title", "description", "contact_name"}, flags={"fulltext"})})
 * @ORM\Entity()
 */
class Event
{
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
    /**
    * @ORM\OneToOne(targetEntity="Event\EventBundle\Entity\Images", cascade={"persist", "remove"})
    * @ORM\JoinColumn(name="image_id", referencedColumnName="id", nullable=true)
    * @Assert\Valid()
    */
    private $images;
    /**
    * @ORM\OneToMany(targetEntity="Event\EventBundle\Entity\FileEvent", mappedBy="event",cascade={"persist"})
    * @ORM\JoinColumn(nullable=true)
    * @Assert\Valid()
    */
    private $files;

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
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\Length(min=5)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Assert\NotBlank()
     */
    private $description;
    /**
     * @var string
     *
     * @ORM\Column(name="contact_name", type="string", length=255)
     * @Assert\Length(min=2)
     */
    private $contact_name;
    /**
     * @var string
     *
     * @ORM\Column(name="contact_email", type="string", length=255)
     * @Assert\Email()
     */
    private $contact_email;
    /**
     * @var string
     *
     * @ORM\Column(name="place", type="string", length=255)
     */
    private $place;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_create", type="datetime")
     */
    private $dateCreate;
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
     * @var \headlines
     *
     * @ORM\Column(name="headlines", type="boolean", nullable=true)
     */
    private $headlines;

    public function __construct()
    {
      $this->sector = new ArrayCollection();
      $this->publics = new ArrayCollection();
      $this->type = new ArrayCollection();
      $this->files = new ArrayCollection();
      $this->dateCreate = new \DateTime();

    }

    public function __toString(){
      return (string) $this->getPublics();
      return (string) $this->getFile();

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
     * Set author
     *
     * @param string $author
     *
     * @return Event
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Event
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Event
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set contactName
     *
     * @param string $contactName
     *
     * @return Event
     */
    public function setContactName($contactName)
    {
        $this->contact_name = $contactName;

        return $this;
    }

    /**
     * Get contactName
     *
     * @return string
     */
    public function getContactName()
    {
        return $this->contact_name;
    }

    /**
     * Set contactEmail
     *
     * @param string $contactEmail
     *
     * @return Event
     */
    public function setContactEmail($contactEmail)
    {
        $this->contact_email = $contactEmail;

        return $this;
    }

    /**
     * Get contactEmail
     *
     * @return string
     */
    public function getContactEmail()
    {
        return $this->contact_email;
    }

    /**
     * Set place
     *
     * @param string $place
     *
     * @return Event
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set dateStart
     *
     * @param \DateTime $dateStart
     *
     * @return Event
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
     * @return Event
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
     * Set dateCreate
     *
     * @param \DateTime $dateCreate
     * @return Images
     */
    public function setDateCreate($dateCreate)
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }

    /**
     * Get dateCreate
     *
     * @return \DateTime
     */
    public function getDateCreate()
    {
        return $this->dateCreate;
    }

    /**
     * Set headlines
     *
     * @param \Boolean $dateEnd
     *
     * @return Event
     */
    public function setHeadlines($headlines)
    {
        $this->headlines = $headlines;

        return $this;
    }

    /**
     * Get headlines
     *
     * @return \Boolean
     */
    public function getHeadlines()
    {
        return $this->headlines;
    }




    public function setPublics($publics)
    {
        $this->publics[] = $publics;

        return $this;
    }
    /**
     * Get publics
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPublics()
    {
        return $this->publics;
    }

    /**
     * Add type
     *
     * @param \Event\EventBundle\Entity\Type $type
     *
     * @return Event
     */
    public function setType($type)
    {
        $this->type[] = $type;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }
    /**
     * set sector
     *
     * @param \Event\EventBundle\Entity\Sector $sector
     *
     * @return Event
     */
    public function setSector($sector)
    {
      $this->sector[] = $sector;

      return $this;
    }
    /**
     * Get sector
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSector()
    {
        return $this->sector;
    }
    /**
     * set images
     *
     * @param \Event\EventBundle\Entity\Images $images
     *
     * @return Event
     */
    public function setImages(\Event\EventBundle\Entity\Images $images = null)
    {
      $this->images = $images;

      return $this;
    }
    /**
     * Get images
     *
     * @return \Event\EventBundle\Entity\Images
     */
    public function getImages()
    {
      return $this->images;
    }

    /**
     * add files
     *
     * @param \Event\EventBundle\Entity\FileEvent $files
     *
     * @return Event
     */
    public function addFile(\Event\EventBundle\Entity\FileEvent $file)
    {
      $this->files[] = $file;
      $file->setEvent($this);
      return $this;
    }
    public function removeFile(\Event\EventBundle\Entity\FileEvent $file)
     {
       $this->files->removeElement($file);
       $file->setEvent(null);
     }

    /**
     * Get files
     *
     * @return \Event\EventBundle\Entity\FileEvent
     */
    public function getFiles()
    {
      return $this->files;
    }


    /**
     * Add sector
     *
     * @param \Event\EventBundle\Entity\Sector $sector
     *
     * @return Event
     */
    public function addSector(\Event\EventBundle\Entity\Sector $sector)
    {
        $this->sector[] = $sector;

        return $this;
    }

    /**
     * Remove sector
     *
     * @param \Event\EventBundle\Entity\Sector $sector
     */
    public function removeSector(\Event\EventBundle\Entity\Sector $sector)
    {
        $this->sector->removeElement($sector);
    }

    /**
     * Add public
     *
     * @param \Event\EventBundle\Entity\Publics $public
     *
     * @return Event
     */
    public function addPublic(\Event\EventBundle\Entity\Publics $public)
    {
        $this->publics[] = $public;

        return $this;
    }

    /**
     * Remove public
     *
     * @param \Event\EventBundle\Entity\Publics $public
     */
    public function removePublic(\Event\EventBundle\Entity\Publics $public)
    {
        $this->publics->removeElement($public);
    }

    /**
     * Add type
     *
     * @param \Event\EventBundle\Entity\Type $type
     *
     * @return Event
     */
    public function addType(\Event\EventBundle\Entity\Type $type)
    {
        $this->type[] = $type;

        return $this;
    }

    /**
     * Remove type
     *
     * @param \Event\EventBundle\Entity\Type $type
     */
    public function removeType(\Event\EventBundle\Entity\Type $type)
    {
        $this->type->removeElement($type);
    }
}
