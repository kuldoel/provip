<?php

namespace Provip\EventsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Provip\ProvipBundle\Entity\Internship;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 */
class BroadcastCompany extends Event
{

    public function getRecipients()
    {
        $recipients = new \Doctrine\Common\Collections\ArrayCollection();
        $recipients[] = $this->getAuthor();

        $company = $this->getAuthor()->getCompany();

        foreach($company->getStaff() as $staffMember) {
            if(!$recipients->contains($staffMember)) {
                $recipients[] = $staffMember;
            }
        }

        foreach($company->getOpportunities() as $opportunities) {
            foreach($opportunities->getApplications() as $application) {
                if($application->getInternship() instanceof Internship) {
                    if(!$application->getInternship()->getCompleted()) {
                        $recipients[] = $application->getStudent();
                    }
                }

            }
        }

        return $recipients;
    }



}