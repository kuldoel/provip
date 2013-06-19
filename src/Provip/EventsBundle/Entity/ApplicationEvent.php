<?php

namespace Provip\EventsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 */
class ApplicationEvent extends Event
{

    /**
     * @ORM\ManyToOne(targetEntity="Provip\ProvipBundle\Entity\Application", inversedBy="applicationEvents")
     * @ORM\JoinColumn(name="application_id", referencedColumnName="id")
     * @Assert\Valid
     **/
    protected $application;



    /**
     * Set application
     *
     * @param \Provip\ProvipBundle\Entity\Application $application
     * @return ApplicationEvent
     */
    public function setApplication(\Provip\ProvipBundle\Entity\Application $application = null)
    {
        $this->application = $application;
    
        return $this;
    }

    /**
     * Get application
     *
     * @return \Provip\ProvipBundle\Entity\Application 
     */
    public function getApplication()
    {
        return $this->application;
    }

}