<?php

namespace Provip\EventsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 */
class StudentEvent extends Event
{

    /**
     * @ORM\ManyToOne(targetEntity="Provip\UserBundle\Entity\User", inversedBy="studentEvents")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     * @Assert\Valid
     **/
    protected $student;

    public function __construct($author, $message, $actionUrl, $privacy, $student) {
        parent:: __construct($author, $message, $actionUrl, $privacy);
        $this->student = $student;
    }


    /**
     * Set student
     *
     * @param \Provip\UserBundle\Entity\User $student
     * @return StudentEvent
     */
    public function setStudent(\Provip\UserBundle\Entity\User $student = null)
    {
        $this->student = $student;
    
        return $this;
    }

    /**
     * Get student
     *
     * @return \Provip\UserBundle\Entity\User 
     */
    public function getStudent()
    {
        return $this->student;
    }


    public function getRecipients()
    {
        $recipients = new \Doctrine\Common\Collections\ArrayCollection();
        $recipients[] = $this->getStudent();

        $studyProgram = $this->getStudent()->getEnrollment()->getStudyProgram();

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


        return $recipients;
    }



}