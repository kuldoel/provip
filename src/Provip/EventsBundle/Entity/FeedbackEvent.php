<?php

namespace Provip\EventsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Provip\UserBundle\Entity\User;
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $evaluationValue;


    public function __construct(User $user)
    {
        $this->author = $user;
    }

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


    public function getRecipients()
    {
        $recipients = new \Doctrine\Common\Collections\ArrayCollection();
        $recipients[] = $this->getActivityUpdateEvent()->getAuthor();

        $studyProgram = $this->getActivityUpdateEvent()->getAuthor()->getStudyProgram();

        if($this->getPrivacy() == 'privacy.hei.only' || $this->getPrivacy() == 'privacy.internship') {
            foreach($studyProgram->getEnrollments() as $enrollment)
            {
                if(!$recipients->contains($enrollment->getStudent()))
                {
                    $recipients[] = $enrollment->getStudent();
                }
            }

            foreach($studyProgram->getStaff() as $staffMember)
            {
                if(!$recipients->contains($staffMember))
                {
                    $recipients[] = $staffMember;
                }
            }

            if(!$recipients->contains($studyProgram->getAdmin()))
            {
                $recipients[] = $studyProgram->getAdmin();
            }
        }

        if($this->getPrivacy() == 'privacy.company.only' || $this->getPrivacy() == 'privacy.internship') {
            $currentInternship =$this->getActivityUpdateEvent()->getAuthor()->getCurrentInternship();

            if($currentInternship) {
                $company = $currentInternship->getApplication()->getOpportunity()->getCompany();

                foreach($company->getStaff() as $staffMember) {
                    if(!$recipients->contains($staffMember))
                    {
                        $recipients[] = $staffMember;
                    }
                }
            }
        }

        return $recipients;
    }

    public function getActivity() {
        return $this->getActivityUpdateEvent()->getActivity();
    }



}