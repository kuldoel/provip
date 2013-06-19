<?php

namespace Provip\ProvipBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="enrollments")
 */
class Enrollment
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Default approved is false
     *
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     */
    protected $approved = false;


    /**
     * @ORM\ManyToOne(targetEntity="HigherEducationalInstitution", inversedBy="enrollments")
     * @ORM\JoinColumn(name="organization_id", referencedColumnName="id")
     * @Assert\Valid
     **/
    protected $organization;



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
     * Set approved
     *
     * @param boolean $approved
     * @return Enrollment
     */
    public function setApproved($approved)
    {
        $this->approved = $approved;
    
        return $this;
    }

    /**
     * Get approved
     *
     * @return boolean 
     */
    public function getApproved()
    {
        return $this->approved;
    }

    /**
     * Set organization
     *
     * @param \Provip\ProvipBundle\Entity\HigherEducationalInstitution $organization
     * @return Enrollment
     */
    public function setOrganization(\Provip\ProvipBundle\Entity\HigherEducationalInstitution $organization = null)
    {
        $this->organization = $organization;
    
        return $this;
    }

    /**
     * Get organization
     *
     * @return \Provip\ProvipBundle\Entity\HigherEducationalInstitution 
     */
    public function getOrganization()
    {
        return $this->organization;
    }
}