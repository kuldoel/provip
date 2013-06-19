<?php

namespace Provip\ProvipBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="internships")
 */
class Internship
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     * @Assert\Type(type="string")
     */
    protected $publicId;


    /**
     * Default completed is false
     *
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     */
    protected $completed = false;

    /**
     *
     * @ORM\OneToOne(targetEntity="Application")
     * @ORM\JoinColumn(name="application_id", referencedColumnName="id")
     * @Assert\Valid
     */
    protected $application;


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
     * Set publicId
     *
     * @param string $publicId
     * @return Internship
     */
    public function setPublicId($publicId)
    {
        $this->publicId = $publicId;
    
        return $this;
    }

    /**
     * Get publicId
     *
     * @return string 
     */
    public function getPublicId()
    {
        return $this->publicId;
    }

    /**
     * Set completed
     *
     * @param boolean $completed
     * @return Internship
     */
    public function setCompleted($completed)
    {
        $this->completed = $completed;
    
        return $this;
    }

    /**
     * Get completed
     *
     * @return boolean 
     */
    public function getCompleted()
    {
        return $this->completed;
    }

    /**
     * Set application
     *
     * @param \Provip\ProvipBundle\Entity\Application $application
     * @return Internship
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