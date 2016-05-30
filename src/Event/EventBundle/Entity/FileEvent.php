<?php

namespace Event\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * @ORM\Table(name="files")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class FileEvent
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
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="size", type="integer")
     */
    private $size;

    /**
     * @var UploadedFile
     */
    private $file;

    /**
     * @ORM\ManyToOne(targetEntity="Event\EventBundle\Entity\Event", inversedBy="files")
     * @ORM\JoinColumn(name="event_id")
     **/
    private $event;

    /**
     * @ORM\Column(type="array")
     */
    private $paths;


    /**
    * @param UploadedFile $uploadedFile
    */
     function __construct(UploadedFile $uploadedFile)
     {
         $path = sha1(uniqid(mt_rand(), true)).'.'.$uploadedFile->guessExtension();
         $this->setPath($path);
         $this->setSize($uploadedFile->getClientSize());
         $this->setName($uploadedFile->getClientOriginalName());
         $uploadedFile->move($this->getUploadRootDir(), $path);
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
      * Set path
      *
      * @param string $path
      * @return File
      */
     public function setPath($path)
     {
         $this->path = $path;
         return $this;
     }
     /**
      * Get path
      *
      * @return string
      */
     public function getPath()
     {
         return $this->path;
     }
     /**
      * Set name
      *
      * @param string $name
      * @return File
      */
     public function setName($name)
     {
         $this->name = $name;
         return $this;
     }
     /**
      * Get name
      *
      * @return string
      */
     public function getName()
     {
         return $this->name;
     }
     /**
      * Set size
      *
      * @param integer $size
      * @return File
      */
     public function setSize($size)
     {
         $this->size = $size;
         return $this;
     }
     /**
      * Get size
      *
      * @return integer
      */
     public function getSize()
     {
         return $this->size;
     }
     /**
      * @return mixed
      */
     public function getFile()
     {
         return $this->file;
     }
     /**
      * @param mixed $file
      */
     public function setFile($file)
     {
         $this->file = $file;
     }
     /**
      * @return mixed
      */
     public function getEvent()
     {
         return $this->event;
     }
     /**
      * @param mixed $document
      */
     public function setEvent($event)
     {
         $this->event = $event;
     }
     /**
      * @return string
      */
     protected function getUploadRootDir()
     {
         return __DIR__.'/../../../../web/'.$this->getUploadDir();
     }
     /**
      * @return string
      */
     protected function getUploadDir()
     {
         return 'uploads/documents';
     }
     /**
      * @ORM\PostRemove()
      */
     public function removeFile()
     {
         if ($file = $this->getUploadRootDir().'/'.$this->path) {
             unlink($file);
         }
     }
 }
