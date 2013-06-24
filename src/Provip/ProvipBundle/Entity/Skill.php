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
     * @ORM\ManyToMany(targetEntity="StudyProgram", mappedBy="skills")
     **/
    protected $studyPrograms;

    /**
     * @ORM\ManyToMany(targetEntity="Opportunity", mappedBy="skills")
     **/
    protected $opportunities;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->studyPrograms = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add studyPrograms
     *
     * @param \Provip\ProvipBundle\Entity\StudyProgram $studyPrograms
     * @return Skill
     */
    public function addStudyProgram(\Provip\ProvipBundle\Entity\StudyProgram $studyProgram)
    {
        $this->studyPrograms[] = $studyProgram;
    
        return $this;
    }

    /**
     * Remove studyPrograms
     *
     * @param \Provip\ProvipBundle\Entity\StudyProgram $studyPrograms
     */
    public function removeStudyProgram(\Provip\ProvipBundle\Entity\StudyProgram $studyProgram)
    {
        $this->studyPrograms->removeElement($studyProgram);
    }

    /**
     * Get studyPrograms
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStudyPrograms()
    {
        return $this->studyPrograms;
    }

    /**
     * Add opportunities
     *
     * @param \Provip\ProvipBundle\Entity\Opportunity $opportunities
     * @return Skill
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