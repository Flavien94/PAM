<?php

namespace Event\EventBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;




/**
 * Event
 *
 * @ORM\Table(name="event",options={"engine"="MyISAM"}, indexes={@ORM\Index(columns={"title", "description", "contact_name"}, flags={"fulltext"})})
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 */
class Event
{
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
    /**
    * @ORM\OneToOne(targetEntity="Event\EventBundle\Entity\Place", cascade={"persist", "remove"})
    * @ORM\JoinColumn(name="place_id", referencedColumnName="id", nullable=true)
    * @Assert\Valid()
    */
    private $place;
    /**
    * @ORM\OneToOne(targetEntity="Event\EventBundle\Entity\Images", cascade={"persist", "remove"})
    * @ORM\JoinColumn(name="image_id", referencedColumnName="id", nullable=true)
    * @Assert\Valid()
    */
    private $images;
    /**
     * @var Links
     *
     * @ORM\OneToMany(targetEntity="Event\EventBundle\Entity\Links", mappedBy="event", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     *
     */
    public $links;
    /**
     * @var FileEvent
     *
     * @ORM\OneToMany(targetEntity="Event\EventBundle\Entity\FileEvent", mappedBy="event", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $files;

    /**
     * @var ArrayCollection
     */
    private $uploadedFiles;
    /**
     * @var ArrayCollection
     */
    private $uploadedLinks;

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
     * @ORM\Column(name="author", type="string", length=255, nullable=true)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     * @Assert\Length(min=5, minMessage="Titre : Le titre doit contenir au moins 5 caractères")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(min=20, minMessage="Description : Ce champs doit contenir au minimun 20 caractères")
     */
    private $description;
    /**
     * @var string
     *
     * @ORM\Column(name="contact_name", type="string", length=255, nullable=true)
     * @Assert\Length(min=2, minMessage="Nom du Contact : Ce champs doit contenir au minimun 2 caractères")
     */
    private $contact_name;
    /**
     * @var string
     *
     * @ORM\Column(name="contact_email", type="string", length=255, nullable=true)
     * @Assert\Email(message="Email du Contact :Ce n'est pas une adresse email valide")
     */
    private $contact_email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_create", type="datetime")
     */
    private $dateCreate;
    /**
     * @var \Date
     *
     * @ORM\Column(name="date_start", type="date", nullable=false)
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
     * @ORM\Column(name="date_end", type="date", nullable=false)
     */
    private $dateEnd;
    /**
     * @var \Time
     *
     * @ORM\Column(name="time_end", type="time", nullable=true)
     */
    private $timeEnd;


    /**
     * @var \headlines
     *
     * @ORM\Column(name="headlines", type="boolean", nullable=true)
     */
    private $headlines;

    /**
     * @var \scratch
     *
     * @ORM\Column(name="scratch", type="boolean", nullable=true)
     */
    private $scratch;

    private $SearchIndexEvents;

    public function __construct()
    {
      // $this->sector = new ArrayCollection();
      // $this->publics = new ArrayCollection();
      // $this->type = new ArrayCollection();
      $this->files = new ArrayCollection();
      $this->uploadedFiles = new ArrayCollection();
      $this->links = new ArrayCollection();
      $this->dateCreate = new \DateTime();
      $this->dateStart = new \DateTime();
    }

    public function __toString(){
      // return (string) $this->getPublics();
      return (string) $this->getFiles();
      return (string) $this->getLinks();

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
     * Set dateStart
     *
     * @param \Date $dateStart
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
     * @return Event
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
     * @return Event
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
     * @param \Boolean $headlines
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

    /**
     * Set scratch
     *
     * @param \Boolean $scratch
     *
     * @return Event
     */
    public function setScratch($scratch)
    {
        $this->scratch = $scratch;

        return $this;
    }

    /**
     * Get scratch
     *
     * @return \Boolean
     */
    public function getScratch()
    {
        return $this->scratch;
    }


    public function setPublics($publics)
    {
        $this->publics = $publics;

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
        $this->type = $type;

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
      $this->sector = $sector;

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
     * set place
     *
     * @param \Event\EventBundle\Entity\Place $place
     *
     * @return Event
     */
    public function setPlace(\Event\EventBundle\Entity\Place $place = null)
    {
      $this->place = $place;

      return $this;
    }
    /**
     * Get place
     *
     * @return \Event\EventBundle\Entity\Place
     */
    public function getPlace()
    {
      return $this->place;
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
    
    public function getFiles() {
        return $this->files;
    }
    public function setFiles(array $files) {
        $this->files = $files;
    }
    /**
     * @return ArrayCollection
     */
    public function getUploadedFiles()
    {
        return $this->uploadedFiles;
    }
    /**
     * @param ArrayCollection $uploadedFiles
     */
    public function setUploadedFiles($uploadedFiles)
    {
        $this->uploadedFiles = $uploadedFiles;
    }
    /**
     * @ORM\PreFlush()
     */
    public function upload()
    {
      if(is_array($this) || is_object($this))
      {
        foreach($this->uploadedFiles as $uploadedFile)
        {
            if ($uploadedFile) {
                $file = new FileEvent($uploadedFile);
                $this->getFiles()->add($file);
                $file->setEvent($this);
                unset($uploadedFile);
            }
        }
      }
     }
     public function getLinks() {
         return $this->links;
     }
     public function setLinks(array $links) {
         $this->links = $links;
     }
     /**
      * @return ArrayCollection
      */
     public function getUploadedLinks()
     {
         return $this->uploadedLinks;
     }
     /**
      * @param ArrayCollection $uploadedLinks
      */
     public function setUploadedLinks($uploadedLinks)
     {
         $this->uploadedLinks = $uploadedLinks;
     }
     /**
      * @ORM\PreFlush()
      */
     public function uploadLink()
     {
       if(is_array($this) || is_object($this))
       {
         foreach($this->uploadedLinks as $uploadedLink)
         {
             if ($uploadedLink) {
                 $link = new Links($uploadedLink);
                 $this->getLinks()->add($link);
                 $link->setEvent($this);
                 $link->setUrl($uploadedLink->url);
                 dump($link);
                 unset($uploadedLink);
             }
         }
       }
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
        $this->sector = $sector;

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
        $this->publics = $public;

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
        $this->type = $type;

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


    /**
     * Add file
     *
     * @param \Event\EventBundle\Entity\FileEvent $file
     *
     * @return Event
     */
    public function addFile(\Event\EventBundle\Entity\FileEvent $file)
    {
        $this->files[] = $file;

        return $this;
    }

    /**
     * Remove file
     *
     * @param \Event\EventBundle\Entity\FileEvent $file
     */
    public function removeFile(\Event\EventBundle\Entity\FileEvent $file)
    {
        $this->files->removeElement($file);
    }
    /**
     * Add link
     *
     * @param \Event\EventBundle\Entity\Links $link
     *
     * @return Event
     */
    public function addLink(\Event\EventBundle\Entity\Links $link)
    {
        $this->links[] = $link;
        return $this;
    }

    /**
     * Remove link
     *
     * @param \Event\EventBundle\Entity\Links $link
     */
    public function removeLink(\Event\EventBundle\Entity\Links $link)
    {
        $this->links->removeElement($link);
    }
}
