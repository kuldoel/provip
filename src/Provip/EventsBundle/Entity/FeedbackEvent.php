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


}