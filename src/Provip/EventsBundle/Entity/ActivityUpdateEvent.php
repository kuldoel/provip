<?php

namespace Provip\EventsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Provip\ProvipBundle\Entity\Activity;
use Provip\UserBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 */
class ActivityUpdateEvent extends Event
{

    /**
     * @ORM\ManyToOne(targetEntity="Provip\ProvipBundle\Entity\Activity", inversedBy="activityUpdateEvents", cascade={"persist"})
     * @ORM\JoinColumn(name="activity_id", referencedColumnName="id")
     * @Assert\Valid
     **/
    protected $activity;

    /**
     * @ORM\OneToMany(targetEntity="FeedbackEvent", mappedBy="activityUpdateEvent")
     * @Assert\Valid
     */
    protected $feedbackEvents;


    protected $state;


    /**
     * Constructor
     */
    public function __construct()
    {

        $this->feedbackEvents = new \Doctrine\Common\Collections\ArrayCollection();
    }
    

    /**
     * Set activity
     *
     * @param \Provip\ProvipBundle\Entity\Activity $activity
     * @return ActivityUpdateEvent
     */
    public function setActivity(\Provip\ProvipBundle\Entity\Activity $activity = null)
    {
        $this->activity = $activity;
    
        return $this;
    }

    /**
     * Get activity
     *
     * @return \Provip\ProvipBundle\Entity\Activity 
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * Add feedbackEvents
     *
     * @param \Provip\EventsBundle\Entity\FeedbackEvent $feedbackEvents
     * @return ActivityUpdateEvent
     */
    public function addFeedbackEvent(\Provip\EventsBundle\Entity\FeedbackEvent $feedbackEvent)
    {
        $this->feedbackEvents[] = $feedbackEvent;
    
        return $this;
    }

    /**
     * Remove feedbackEvents
     *
     * @param \Provip\EventsBundle\Entity\FeedbackEvent $feedbackEvents
     */
    public function removeFeedbackEvent(\Provip\EventsBundle\Entity\FeedbackEvent $feedbackEvent)
    {
        $this->feedbackEvents->removeElement($feedbackEvent);
    }

    /**
     * Get feedbackEvents
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFeedbackEvents()
    {
        return $this->feedbackEvents;
    }

    public function setActivityState($state)
    {
       $this->state = $state;

        return $this;
    }


    public function getActivityState()
    {
        if($this->getActivity() instanceof Activity)
        {
            return $this->getActivity()->getState();
        }
        else
        {
            return "Not yet started";
        }
    }

    public function getState()
    {
        return $this->state;
    }

}