<?php

namespace Provip\EventsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="events")
 *
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"activityupdate" = "ActivityUpdateEvent", "application" = "ApplicationEvent", "feedback" = "FeedbackEvent", "student" = "StudentEvent", "simpleevent" = "Event", "broadcasthei" = "BroadcastHei", "broadcastcompany" = "BroadcastCompany"})
 *
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type(type="string")
     */
    protected $message;


    /**
     *
     * @ORM\Column(type="string", length=512, nullable=true)
     * @Assert\Type(type="string")
     */
    protected $actionUrl;

    /**
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     */
    protected $privacy;

    /**
     * Optional Picture
     *
     *
     * @ORM\OneToOne(targetEntity="Picture")
     * @ORM\JoinColumn(name="picture_id", referencedColumnName="id", nullable=true)
     *
     */
    protected $picture;

    /**
     *
     *
     * @ORM\OneToOne(targetEntity="Provip\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     *
     * @Assert\Valid
     */
    protected $author;

    /**
     * @var datetime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @var datetime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    /**
     * @ORM\OneToMany(targetEntity="Notification", mappedBy="event",cascade={"persist","remove"})
     */
    protected $notifications;

    public function __construct($author, $message, $actionUrl, $privacy) {
        $this->author = $author;
        $this->message = $message;
        $this->actionUrl = $actionUrl;
        $this->privacy = $privacy;
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
     * Set message
     *
     * @param string $message
     * @return Event
     */
    public function setMessage($message)
    {
        $this->message = $message;
    
        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set privacy
     *
     * @param string $privacy
     * @return Event
     */
    public function setPrivacy($privacy)
    {
        $this->privacy = $privacy;
    
        return $this;
    }

    /**
     * Get privacy
     *
     * @return string 
     */
    public function getPrivacy()
    {
        return $this->privacy;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Event
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Event
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set picture
     *
     * @param \Provip\EventsBundle\Entity\Picture $picture
     * @return Event
     */
    public function setPicture(\Provip\EventsBundle\Entity\Picture $picture = null)
    {
        $this->picture = $picture;
    
        return $this;
    }

    /**
     * Get picture
     *
     * @return \Provip\EventsBundle\Entity\Picture 
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set author
     *
     * @param \Provip\UserBundle\Entity\User $author
     * @return Event
     */
    public function setAuthor(\Provip\UserBundle\Entity\User $author = null)
    {
        $this->author = $author;
    
        return $this;
    }

    /**
     * Get author
     *
     * @return \Provip\UserBundle\Entity\User 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $actionUrl
     */
    public function setActionUrl($actionUrl)
    {
        $this->actionUrl = $actionUrl;
    }

    /**
     * @return mixed
     */
    public function getActionUrl()
    {
        return $this->actionUrl;
    }


    public function getRecipients() {

    }

    public function getActivity() {

    }

    /**
     * @param mixed $notifications
     */
    public function setNotifications($notifications)
    {
        $this->notifications = $notifications;
    }

    /**
     * @return mixed
     */
    public function getNotifications()
    {
        return $this->notifications;
    }




}