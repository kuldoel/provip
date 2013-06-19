<?php

namespace Provip\ProvipBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 */
class Company extends Organization
{

    /**
     *
     * @ORM\Column(type="text")
     * @Assert\NotNull()
     * @Assert\Type(type="string")
     */
    protected $description;


    /**
     * @ORM\OneToMany(targetEntity="Opportunity", mappedBy="company")
     * @Assert\Valid
     */
    protected $opportunities;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->opportunities = new \Doctrine\Common\Collections\ArrayCollection();
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


}