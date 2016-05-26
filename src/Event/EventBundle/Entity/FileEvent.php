<?php

namespace Event\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * FileEvent
 *
 * @ORM\Table("file_event")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 */
class FileEvent
{
    /**
    * @ORM\ManyToOne(targetEntity="Event\EventBundle\Entity\Event", inversedBy="files",cascade={"persist"})
    * @ORM\JoinColumn(nullable=true)
    */
    private $event;
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
     * @ORM\COlumn(name="updated_at",type="datetime", nullable=true)
     */
    private $updateAt;

    /**
     * @ORM\PostLoad()
     */
    public function postLoad()
    {
        $this->updateAt = new \DateTime();
    }

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $alt;

    /**
     * @ORM\Column(type="string",length=255, nullable=true)
     */
    private $url;

    /**
     * Image file
     *
     * @var File
     *
     * @Assert\File(
     *     maxSize = "1M",
     *     mimeTypes = {"application/pdf"},
     *     maxSizeMessage = "The maxmimum allowed file size is 1MB.",
     *     mimeTypesMessage = "Only the filetypes image are allowed."
     * )
     */
    public $file;

    public function __construct()
    {
        $this->alt = 'document';
        $this->url = '';
    }


    public function getUploadRootDir()
    {
        return __dir__.'/../../../../web/uploads/files';
    }

    public function getAbsolutePath()
    {
        return null === $this->url ? null : $this->getUploadRootDir().'/'.$this->url;
    }

    public function getAssetPath()
    {
        return 'uploads/'.$this->url;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        $this->tempFile = $this->getAbsolutePath();
        $this->oldFile = $this->getUrl();
        $this->updateAt = new \DateTime();

        if (null !== $this->file)
            $this->url= sha1(uniqid(mt_rand(),true)).'.'.$this->file->guessExtension();
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null !== $this->file) {
            $this->file->move($this->getUploadRootDir(),$this->url);
            unset($this->file);

            if ($this->oldFile != null) unlink($this->tempFile);
        }
    }

    /**
     * @ORM\PreRemove()
     */
    public function preRemoveUpload()
    {
        $this->tempFile = $this->getAbsolutePath();
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if (file_exists($this->tempFile)) unlink($this->tempFile);
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

    public function getUrl()
    {
        return $this->url;
    }

    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set updateAt
     *
     * @param \DateTime $updateAt
     * @return FileEvent
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get updateAt
     *
     * @return \DateTime
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * Set alt
     *
     * @param string $alt
     * @return FileEvent
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return FileEvent
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }
    public function setEvent(Event $event)
    {
      $this->event = $event;

      return $this;
    }

    public function getEvent()
    {
      return $this->event;
    }
}
