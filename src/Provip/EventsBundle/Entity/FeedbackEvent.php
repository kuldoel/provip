<?php

namespace Provip\EventsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 */
class FeedbackEvent extends Event
{

    /**
     * @ORM\ManyToOne(targetEntity="ActivityUpdateEvent", inversedBy="feedbackEvents")
     * @ORM\JoinColumn(name="activityupdateevent_id", referencedColumnName="id")
     * @Assert\Valid
     **/
    protected $activityUpdateEvent;


    /**
     *
     * @ORM\Column(type="integer", length=11)
     * @Assert\NotNull()
     * @Assert\Type(type="int")
     */
    protected $evaluationValue;


    /**
     * Set evaluationValue
     *
     * @param \int $evaluationValue
     * @return FeedbackEvent
     */
    public function setEvaluationValue($evaluationValue)
    {
        $this->evaluationValue = $evaluationValue;
    
        return $this;
    }

    /**
     * Get evaluationValue
     *
     * @return \int 
     */
    public function getEvaluationValue()
    {
        return $this->evaluationValue;
    }


    /**
     * Set activityUpdateEvent
     *
     * @param \Provip\EventsBundle\Entity\ActivityUpdateEvent $activityUpdateEvent
     * @return FeedbackEvent
     */
    public function setActivityUpdateEvent(\Provip\EventsBundle\Entity\ActivityUpdateEvent $activityUpdateEvent = null)
    {
        $this->activityUpdateEvent = $activityUpdateEvent;
    
        return $this;
    }

    /**
     * Get activityUpdateEvent
     *
     * @return \Provip\EventsBundle\Entity\ActivityUpdateEvent 
     */
    public function getActivityUpdateEvent()
    {
        return $this->activityUpdateEvent;
    }


}