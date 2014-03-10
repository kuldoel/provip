<?php

namespace Provip\ProvipBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Provip\UserBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 */
class Company extends Organization
{

    /**
     *
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Type(type="string")
     */
    protected $description;


    /**
     * @ORM\OneToMany(targetEntity="Opportunity", mappedBy="company")
     * @Assert\Valid
     */
    protected $opportunities;


    /**
     * @ORM\OneToMany(targetEntity="Provip\UserBundle\Entity\User", mappedBy="company", cascade={"persist", "remove"})
     */
    protected $staff;


    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->opportunities = new \Doctrine\Common\Collections\ArrayCollection();
        $this->staff = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set description
     *
     * @param string $description
     * @return Company
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }


    /**
     * Add opportunities
     *
     * @param \Provip\ProvipBundle\Entity\Opportunity $opportunities
     * @return Company
     */
    public function addOpportunity(\Provip\ProvipBundle\Entity\Opportunity $opportunity)
    {
        $this->opportunities[] = $opportunity;
    
        return $this;
    }

    /**
     * Remove opportunities
     *
     * @param \Provip\ProvipBundle\Entity\Opportunity $opportunities
     */
    public function removeOpportunity(\Provip\ProvipBundle\Entity\Opportunity $opportunity)
    {
        $this->opportunities->removeElement($opportunity);
    }

    /**
     * Get opportunities
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOpportunities()
    {
        return $this->opportunities;
    }

    /**
     * Add staff
     *
     * @param \Provip\UserBundle\Entity\User $staff
     * @return Organization
     */
    public function addStaff(\Provip\UserBundle\Entity\User $staff)
    {
        $this->staff[] = $staff;

        return $this;
    }

    /**
     * Remove staff
     *
     * @param \Provip\UserBundle\Entity\User $staff
     */
    public function removeStaff(\Provip\UserBundle\Entity\User $staff)
    {
        $this->staff->removeElement($staff);
    }

    /**
     * Get staff
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStaff()
    {
        return $this->staff;
    }

    public function isStaffMember(User $user)
    {
        return $this->staff->contains($user);
    }


}