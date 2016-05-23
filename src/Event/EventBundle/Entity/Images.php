<?php

namespace Event\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
*Images
*
*@ORM\Table()
*@ORM\Entity;
*/
class Images
{
  /**
  *@var integer
  *
  *@ORM\Column(name="id", type="integer")
  *@ORM\Id
  *@ORM\GeneratedValue(strategy="AUTO")
  */
  private $id;
  /**
  *@var string
  *
  *@ORM\Column(name="url", type="string", length=255)
  */
  private $url;
  /**
  *@var string
  *
  *@ORM\Column(name="alt", type="string", length=255)
  */
  private $alt;

  private $file;

  private $tempFileName;

  public function getFile()
  {
    return $this->file;
  }
  public function setFile(UploadedFile $file = null)
  {
    $this->file = $file;
    if(null === $this->url){
      $this->tempFileName = $this->url;
      $this->url = null;
      $this->alt = null;
    }
  }
  /**
  *@ORM\PrePersist()
  *@ORM\PreUpdate()
  */
  public function preUpload()
  {
    if(null === $this->file){
      return;
    }
    $this->url = $this->file->guessExtension();
    $this->alt = $this->getClientOrigninalName();
  }
  /**
  *@ORM\PrePersist()
  *@ORM\PostUpdate()
  */
  public function upload()
  {
    if(null === $this->file){
      return;
    }
    if(null !== $this->tempFileName){
      $oldFile = $this->getUploadRootDir().'/'.$this->id.'.'.$this->tempFileName;
      if(file_exists($oldFile)){
        unlink($oldFile);
      }
    }
    $name= $this->file->getClientOrigninalName();
    $this->file->move(
      $this->getUploadRootDir(),
      $this->id.'.'.$this->url
    );
  }
  /**
  *@ORM\PreRemove()
  */
  public function getUploadDir()
  {
    return 'uploads/img';
  }
  protected function getUploadRootDir()
  {
    return __DIR__.'/../../../../web'.$this->getUploadDir();
  }
}
