<?php

namespace Provip\EventsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 */
class ActivityUpdateEvent extends Event
{

    /**
     * @ORM\ManyToOne(targetEntity="Provip\ProvipBundle\Entity\Activity", inversedBy="activityUpdateEvents")
     * @ORM\JoinColumn(name="activity_id", referencedColumnName="id")
     * @Assert\Valid
     **/
    protected $activity;

    /**
     * @ORM\OneToMany(targetEntity="FeedbackEvent", mappedBy="activityUpdateEvent")
     * @Assert\Valid
     */
    protected $feedbackEvents;

}