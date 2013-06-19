<?php

namespace Provip\ProvipBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="skills")
 */
class Skill
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * This is the English word for the skill
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     * @Assert\Type(type="string")
     */
    protected $value;

    /**
     * @ORM\Column(length=255, unique=true)
     * @Gedmo\Slug(fields={"value"})
     */
    protected $slug;

    /**
     * @ORM\ManyToMany(targetEntity="HigherEducationalInstitution", mappedBy="skills")
     **/
    protected $higherEducationalInstitutions;

    /**
     * @ORM\ManyToMany(targetEntity="Opportunity", mappedBy="skills")
     **/
    protected $opportunities;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->higherEducationalInstitutions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->opportunities = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set value
     *
     * @param string $value
     * @return Skill
     */
    public function setValue($value)
    {
        $this->value = $value;
    
        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Skill
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add higherEducationalInstitutions
     *
     * @param \Provip\ProvipBundle\Entity\HigherEducationalInstitution $higherEducationalInstitutions
     * @return Skill
     */
    public function addHigherEducationalInstitution(\Provip\ProvipBundle\Entity\HigherEducationalInstitution $higherEducationalInstitutions)
    {
        $this->higherEducationalInstitutions[] = $higherEducationalInstitutions;
    
        return $this;
    }

    /**
     * Remove higherEducationalInstitutions
     *
     * @param \Provip\ProvipBundle\Entity\HigherEducationalInstitution $higherEducationalInstitutions
     */
    public function removeHigherEducationalInstitution(\Provip\ProvipBundle\Entity\HigherEducationalInstitution $higherEducationalInstitutions)
    {
        $this->higherEducationalInstitutions->removeElement($higherEducationalInstitutions);
    }

    /**
     * Get higherEducationalInstitutions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHigherEducationalInstitutions()
    {
        return $this->higherEducationalInstitutions;
    }

    /**
     * Add opportunities
     *
     * @param \Provip\ProvipBundle\Entity\Opportunity $opportunities
     * @return Skill
     */
    public function addOpportunitie(\Provip\ProvipBundle\Entity\Opportunity $opportunities)
    {
        $this->opportunities[] = $opportunities;
    
        return $this;
    }

    /**
     * Remove opportunities
     *
     * @param \Provip\ProvipBundle\Entity\Opportunity $opportunities
     */
    public function removeOpportunitie(\Provip\ProvipBundle\Entity\Opportunity $opportunities)
    {
        $this->opportunities->removeElement($opportunities);
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