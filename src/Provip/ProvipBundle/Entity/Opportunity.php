<?php

namespace Provip\ProvipBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="opportunities")
 */
class Opportunity
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
     * @Assert\NotNull(message="Please enter a title")
     * @Assert\Type(type="string")
     */
    protected $title;

    /**
     *
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank(groups={"complete_opportunity"}, message="Please enter a description for this internship")
     * @Assert\Type(type="string")
     */
    protected $description;


    /**
     *
     * @ORM\Column(type="integer", length=12)
     * @Assert\NotNull(message="Please specify the number of available positions for this internship")
     * @Assert\Type(type="int")
     */
    protected $nbrOfPositions;


    /**
     *
     * @ORM\Column(type="date")
     * @Assert\NotNull(message="Please specify a start date")
     * @Assert\Date()
     */
    protected $startDate;


    /**
     *
     * @ORM\Column(type="date")
     * @Assert\NotNull(message="Please specify an end date")
     * @Assert\Date()
     */
    protected $endDate;


    /**
     *
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotNull(groups={"complete_opportunity"}, message="Please give more information about the selection procedure")
     * @Assert\Type(type="string")
     */
    protected $selectionProcedure;


    /**
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotNull(groups={"complete_opportunity"}, message="Please specify how the applicants can contact your for more information")
     * @Assert\Type(type="string")
     */
    protected $communicationProtocol;


    /**
     * Default published is false
     *
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     */
    protected $published = false;

    /**
     * Default complete is false
     *
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     */
    protected $complete = false;

    /**
     * @ORM\Column(length=255, unique=true)
     * @Gedmo\Slug(fields={"title"})
     */
    protected $slug;


    /**
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="opportunities")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     * @Assert\Valid
     **/
    protected $company;

    /**
     * @ORM\ManyToOne(targetEntity="Provip\UserBundle\Entity\User", inversedBy="mentoring")
     * @ORM\JoinColumn(name="mentor_id", referencedColumnName="id")
     * @Assert\Valid
     **/
    protected $mentor;

    /**
     * @ORM\OneToMany(targetEntity="Deliverable", mappedBy="opportunity",cascade={"persist","remove"})
     * @Assert\Valid
     */
    protected $projectGoals;

    /**
     * @ORM\OneToMany(targetEntity="Application", mappedBy="opportunity",cascade={"persist","remove"})
     * @Assert\Valid
     */
    protected $applications;

    /**
     * @ORM\ManyToMany(targetEntity="Skill", inversedBy="opportunities")
     * @ORM\JoinTable(name="opportunities_skills")
     **/
    protected $skills;


    /**
     * Constructor
     */
    public function __construct(Company $company)
    {
        $this->projectGoals = new \Doctrine\Common\Collections\ArrayCollection();
        $this->applications = new \Doctrine\Common\Collections\ArrayCollection();
        $this->skills = new \Doctrine\Common\Collections\ArrayCollection();
        $this->company = $company;
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
     * Set title
     *
     * @param string $title
     * @return Opportunity
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Opportunity
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
     * Set nbrOfPositions
     *
     * @param integer $nbrOfPositions
     * @return Opportunity
     */
    public function setNbrOfPositions($nbrOfPositions)
    {
        $this->nbrOfPositions = $nbrOfPositions;
    
        return $this;
    }

    /**
     * Get nbrOfPositions
     *
     * @return integer 
     */
    public function getNbrOfPositions()
    {
        return $this->nbrOfPositions;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return Opportunity
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    
        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return Opportunity
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    
        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set selectionProcedure
     *
     * @param string $selectionProcedure
     * @return Opportunity
     */
    public function setSelectionProcedure($selectionProcedure)
    {
        $this->selectionProcedure = $selectionProcedure;
    
        return $this;
    }

    /**
     * Get selectionProcedure
     *
     * @return string 
     */
    public function getSelectionProcedure()
    {
        return $this->selectionProcedure;
    }

    /**
     * Set communicationProtocol
     *
     * @param string $communicationProtocol
     * @return Opportunity
     */
    public function setCommunicationProtocol($communicationProtocol)
    {
        $this->communicationProtocol = $communicationProtocol;
    
        return $this;
    }

    /**
     * Get communicationProtocol
     *
     * @return string 
     */
    public function getCommunicationProtocol()
    {
        return $this->communicationProtocol;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Opportunity
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
     * Set company
     *
     * @param \Provip\ProvipBundle\Entity\Company $company
     * @return Opportunity
     */
    public function setCompany(\Provip\ProvipBundle\Entity\Company $company = null)
    {
        $this->company = $company;
    
        return $this;
    }

    /**
     * Get company
     *
     * @return \Provip\ProvipBundle\Entity\Company 
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set mentor
     *
     * @param \Provip\UserBundle\Entity\User $mentor
     * @return Opportunity
     */
    public function setMentor(\Provip\UserBundle\Entity\User $mentor = null)
    {
        $this->mentor = $mentor;
    
        return $this;
    }

    /**
     * Get mentor
     *
     * @return \Provip\UserBundle\Entity\User 
     */
    public function getMentor()
    {
        return $this->mentor;
    }

    /**
     * Add projectGoals
     *
     * @param \Provip\ProvipBundle\Entity\Deliverable $projectGoals
     * @return Opportunity
     */
    public function addProjectGoal(\Provip\ProvipBundle\Entity\Deliverable $projectGoals)
    {
        $this->projectGoals[] = $projectGoals;
    
        return $this;
    }

    /**
     * Remove projectGoals
     *
     * @param \Provip\ProvipBundle\Entity\Deliverable $projectGoals
     */
    public function removeProjectGoal(\Provip\ProvipBundle\Entity\Deliverable $projectGoals)
    {
        $this->projectGoals->removeElement($projectGoals);
    }

    /**
     * Get projectGoals
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProjectGoals()
    {
        return $this->projectGoals;
    }

    /**
     * Add applications
     *
     * @param \Provip\ProvipBundle\Entity\Application $applications
     * @return Opportunity
     */
    public function addApplication(\Provip\ProvipBundle\Entity\Application $applications)
    {
        $this->applications[] = $applications;
    
        return $this;
    }

    /**
     * Remove applications
     *
     * @param \Provip\ProvipBundle\Entity\Application $applications
     */
    public function removeApplication(\Provip\ProvipBundle\Entity\Application $applications)
    {
        $this->applications->removeElement($applications);
    }

    /**
     * Get applications
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getApplications()
    {
        return $this->applications;
    }

    /**
     * Add skills
     *
     * @param \Provip\ProvipBundle\Entity\Skill $skills
     * @return Opportunity
     */
    public function addSkill(\Provip\ProvipBundle\Entity\Skill $skills)
    {
        $this->skills[] = $skills;
    
        return $this;
    }

    /**
     * Remove skills
     *
     * @param \Provip\ProvipBundle\Entity\Skill $skills
     */
    public function removeSkill(\Provip\ProvipBundle\Entity\Skill $skills)
    {
        $this->skills->removeElement($skills);
    }

    /**
     * Get skills
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * @param mixed $published
     */
    public function setPublished($published)
    {
        $this->published = $published;
    }

    /**
     * @return mixed
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * @param mixed $complete
     */
    public function setComplete($complete)
    {
        $this->complete = $complete;
    }

    /**
     * @return mixed
     */
    public function getComplete()
    {
        return $this->complete;
    }




}