<?php

namespace Event\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="search_index_event", options={"engine"="MyISAM"})
 */
class SearchIndexEvents
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer", nullable=false, unique=true)
     */
    protected $id;

    /**
     * @ORM\Column(name="titre", type="string", length=256, nullable=true)
     * @var string $titre
     */
    protected $title;

    /**
     * @ORM\Column(name="description", type="text", nullable=true)
     *
     * @var text $description
     */
    protected $description;

    /**
     * @ORM\Column(name="contact_name", type="text", nullable=true)
     *
     * @var text $description
     */
    protected $contact_name;


    /**
     * @ORM\Column(name="event_id", type="integer", nullable=true)
     */
    protected $event;
}
