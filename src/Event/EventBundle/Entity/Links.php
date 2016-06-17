<?php

namespace Event\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Links
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Links
{
    /**
     * @var Event
     *
     * @ORM\ManyToOne(targetEntity="Event\EventBundle\Entity\Event", inversedBy="links", cascade={"persist"})
     * @ORM\JoinColumn(referencedColumnName="id",nullable=true)
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
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     * @Assert\Url(message="Cette URL n'est pas valide")
     */
    public $url;

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
     * Set url
     *
     * @param string $url
     *
     * @return Links
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
    /**
     * @return mixed
     */
    public function getEvent()
    {
        return $this->event;
    }
    /**
     * @param mixed $event
     */
    public function setEvent($event)
    {
      $event->addLink($this);
      $this->event = $event;
    }

}
