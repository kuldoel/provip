<?php

namespace Provip\ProvipBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="applications")
 */
class Application
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *
     * @ORM\Column(type="date")
     * @Assert\NotNull()
     * @Assert\Date()
     */
    protected $startDate;

    /**
     *
     * @ORM\Column(type="date")
     * @Assert\NotNull()
     * @Assert\Date()
     */
    protected $endDate;

    /**
     * Default submittedForReview is false
     *
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     */
    protected $submittedForReview = false;

    /**
     * Default approvedByCompany is false
     *
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     */
    protected $approvedByCompany = false;

    /**
     * Default approvedByHei is false
     *
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     */
    protected $approvedByHei = false;

    /**
     * Default rejected is false
     *
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     */
    protected $rejected = false;

    /**
     *
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Type(type="string")
     */
    protected $rejectionReason;


    /**
     * @ORM\ManyToOne(targetEntity="Provip\UserBundle\Entity\User", inversedBy="applications")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     * @Assert\Valid
     **/
    protected $student;

    /**
     * When the STUDENT applies for an internship they have to select a member of STAFF of their HEI which will be the
     * HEI contact person for this internship
     *
     *
     * @ORM\ManyToOne(targetEntity="Provip\UserBundle\Entity\User", inversedBy="coaching")
     * @ORM\JoinColumn(name="coach_id", referencedColumnName="id")
     **/
    protected $coach;

    /**
     * @ORM\ManyToOne(targetEntity="Opportunity", inversedBy="applications")
     * @ORM\JoinColumn(name="opportunity_id", referencedColumnName="id")
     * @Assert\Valid
     **/
    protected $opportunity;

    /**
     * @ORM\OneToMany(targetEntity="Activity", mappedBy="application")
     * @Assert\Valid
     */
    protected $charter;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Organization")
     * @ORM\JoinColumn(name="rejectedby_id", referencedColumnName="id")
     * @Assert\Valid
     */
    protected $rejectedBy;


    /**
     * @ORM\OneToMany(targetEntity="Provip\EventsBundle\Entity\ApplicationEvent", mappedBy="application")
     * @Assert\Valid
     */
    protected $applicationEvents;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->charter = new \Doctrine\Common\Collections\ArrayCollection();
        $this->applicationEvents = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return Application
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
     * @return Application
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
     * Set submittedForReview
     *
     * @param boolean $submittedForReview
     * @return Application
     */
    public function setSubmittedForReview($submittedForReview)
    {
        $this->submittedForReview = $submittedForReview;
    
        return $this;
    }

    /**
     * Get submittedForReview
     *
     * @return boolean 
     */
    public function getSubmittedForReview()
    {
        return $this->submittedForReview;
    }

    /**
     * Set approvedByCompany
     *
     * @param boolean $approvedByCompany
     * @return Application
     */
    public function setApprovedByCompany($approvedByCompany)
    {
        $this->approvedByCompany = $approvedByCompany;
    
        return $this;
    }

    /**
     * Get approvedByCompany
     *
     * @return boolean 
     */
    public function getApprovedByCompany()
    {
        return $this->approvedByCompany;
    }

    /**
     * Set approvedByHei
     *
     * @param boolean $approvedByHei
     * @return Application
     */
    public function setApprovedByHei($approvedByHei)
    {
        $this->approvedByHei = $approvedByHei;
    
        return $this;
    }

    /**
     * Get approvedByHei
     *
     * @return boolean 
     */
    public function getApprovedByHei()
    {
        return $this->approvedByHei;
    }

    /**
     * Set rejected
     *
     * @param boolean $rejected
     * @return Application
     */
    public function setRejected($rejected)
    {
        $this->rejected = $rejected;
    
        return $this;
    }

    /**
     * Get rejected
     *
     * @return boolean 
     */
    public function getRejected()
    {
        return $this->rejected;
    }

    /**
     * Set rejectionReason
     *
     * @param string $rejectionReason
     * @return Application
     */
    public function setRejectionReason($rejectionReason)
    {
        $this->rejectionReason = $rejectionReason;
    
        return $this;
    }

    /**
     * Get rejectionReason
     *
     * @return string 
     */
    public function getRejectionReason()
    {
        return $this->rejectionReason;
    }

    /**
     * Set student
     *
     * @param \Provip\UserBundle\Entity\User $student
     * @return Application
     */
    public function setStudent(\Provip\UserBundle\Entity\User $student = null)
    {
        $this->student = $student;
    
        return $this;
    }

    /**
     * Get student
     *
     * @return \Provip\UserBundle\Entity\User 
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * Set coach
     *
     * @param \Provip\UserBundle\Entity\User $coach
     * @return Application
     */
    public function setCoach(\Provip\UserBundle\Entity\User $coach = null)
    {
        $this->coach = $coach;
    
        return $this;
    }

    /**
     * Get coach
     *
     * @return \Provip\UserBundle\Entity\User 
     */
    public function getCoach()
    {
        return $this->coach;
    }

    /**
     * Set opportunity
     *
     * @param \Provip\ProvipBundle\Entity\Opportunity $opportunity
     * @return Application
     */
    public function setOpportunity(\Provip\ProvipBundle\Entity\Opportunity $opportunity = null)
    {
        $this->opportunity = $opportunity;
    
        return $this;
    }

    /**
     * Get opportunity
     *
     * @return \Provip\ProvipBundle\Entity\Opportunity 
     */
    public function getOpportunity()
    {
        return $this->opportunity;
    }

    /**
     * Add charter
     *
     * @param \Provip\ProvipBundle\Entity\Activity $charter
     * @return Application
     */
    public function addCharter(\Provip\ProvipBundle\Entity\Activity $charter)
    {
        $this->charter[] = $charter;
    
        return $this;
    }

    /**
     * Remove charter
     *
     * @param \Provip\ProvipBundle\Entity\Activity $charter
     */
    public function removeCharter(\Provip\ProvipBundle\Entity\Activity $charter)
    {
        $this->charter->removeElement($charter);
    }

    /**
     * Get charter
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCharter()
    {
        return $this->charter;
    }

    /**
     * Set rejectedBy
     *
     * @param \Provip\ProvipBundle\Entity\Organization $rejectedBy
     * @return Application
     */
    public function setRejectedBy(\Provip\ProvipBundle\Entity\Organization $rejectedBy = null)
    {
        $this->rejectedBy = $rejectedBy;
    
        return $this;
    }

    /**
     * Get rejectedBy
     *
     * @return \Provip\ProvipBundle\Entity\Organization 
     */
    public function getRejectedBy()
    {
        return $this->rejectedBy;
    }

    /**
     * Add applicationEvents
     *
     * @param \Provip\EventsBundle\Entity\ApplicationEvent $applicationEvents
     * @return Application
     */
    public function addApplicationEvent(\Provip\EventsBundle\Entity\ApplicationEvent $applicationEvents)
    {
        $this->applicationEvents[] = $applicationEvents;
    
        return $this;
    }

    /**
     * Remove applicationEvents
     *
     * @param \Provip\EventsBundle\Entity\ApplicationEvent $applicationEvents
     */
    public function removeApplicationEvent(\Provip\EventsBundle\Entity\ApplicationEvent $applicationEvents)
    {
        $this->applicationEvents->removeElement($applicationEvents);
    }

    /**
     * Get applicationEvents
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getApplicationEvents()
    {
        return $this->applicationEvents;
    }
}