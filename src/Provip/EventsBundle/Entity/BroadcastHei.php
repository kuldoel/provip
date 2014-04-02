<?php

namespace Provip\EventsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Provip\ProvipBundle\Entity\StudyProgram;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 */
class BroadcastHei extends Event
{

    public function getRecipients()
    {
        $recipients = new \Doctrine\Common\Collections\ArrayCollection();
        $recipients[] = $this->getAuthor();

        $studyProgram = $this->getAuthor()->getTeachesAt();

        if(!$studyProgram instanceof StudyProgram) {
            $studyProgram = $this->getAuthor()->getAdminOf();
        }

        foreach($this->getAuthor()->getAdminOf() as $studyProgram)
        {
            foreach($studyProgram->getStaff() as $staffMember)
            {
                if(!$recipients->contains($staffMember))
                {
                    $recipients[] = $staffMember;
                }
            }

            foreach($studyProgram->getEnrollments() as $enrollment)
            {
                if(!$recipients->contains($enrollment->getStudent()))
                {
                    $recipients[] = $enrollment->getStudent();
                }
            }

            foreach($studyProgram->getAdmins() as $admin)
            {
                if(!$recipients->contains($admin))
                {
                    $recipients[] = $admin;
                }
            }
        }

        return $recipients;
    }



}