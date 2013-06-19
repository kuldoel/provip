<?php

namespace Provip\EventsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="notifications")
 */
class Notification
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Default new is true
     *
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     */
    protected $new = true;

    /**
     *
     * @ORM\Column(type="string", length=512)
     * @Assert\Type(type="string")
     */
    protected $action;

    /**
     * @ORM\ManyToOne(targetEntity="Provip\UserBundle\Entity\User", inversedBy="notifications")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @Assert\Valid
     */
    protected $user;

    /**
     * @ORM\OneToOne(targetEntity="Event")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     * @Assert\Valid
     */
    protected $event;


}