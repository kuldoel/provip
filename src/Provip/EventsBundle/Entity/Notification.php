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
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Event", cascade={"persist"})
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     */
    protected $event;

    /**
     * Default alert is false
     *
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     */
    protected $alert = false;




    public function __construct($user, $event, $action) {
        $this->user = $user;
        $this->event = $event;
        $this->action = $action;
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
     * Set new
     *
     * @param boolean $new
     * @return Notification
     */
    public function setNew($new)
    {
        $this->new = $new;
    
        return $this;
    }

    /**
     * Get new
     *
     * @return boolean 
     */
    public function getNew()
    {
        return $this->new;
    }

    /**
     * Set action
     *
     * @param string $action
     * @return Notification
     */
    public function setAction($action)
    {
        $this->action = $action;
    
        return $this;
    }

    /**
     * Get action
     *
     * @return string 
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set user
     *
     * @param \Provip\UserBundle\Entity\User $user
     * @return Notification
     */
    public function setUser(\Provip\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Provip\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set event
     *
     * @param \Provip\EventsBundle\Entity\Event $event
     * @return Notification
     */
    public function setEvent(\Provip\EventsBundle\Entity\Event $event = null)
    {
        $this->event = $event;
    
        return $this;
    }

    /**
     * Get event
     *
     * @return \Provip\EventsBundle\Entity\Event 
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param mixed $alert
     */
    public function setAlert($alert)
    {
        $this->alert = $alert;
    }

    /**
     * @return mixed
     */
    public function getAlert()
    {
        return $this->alert;
    }


}