<?php

namespace Provip\ProvipBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="deliverables")
 */
class Deliverable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Opportunity", inversedBy="projectGoals")
     * @ORM\JoinColumn(name="opportunity_id", referencedColumnName="id")
     * @Assert\Valid
     **/
    protected $opportunity;


    /**
     * @ORM\ManyToOne(targetEntity="Enrollment", inversedBy="deliverables")
     * @ORM\JoinColumn(name="enrollment_id", referencedColumnName="id")
     * @Assert\Valid
     **/
    protected $enrollment;


    /**
     * @ORM\OneToMany(targetEntity="Task", mappedBy="deliverable",cascade={"persist","remove"})
     * @Assert\Valid
     */
    protected $tasks;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     */
    protected $description;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->description = 'Description';
        $this->tasks = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set opportunity
     *
     * @param \Provip\ProvipBundle\Entity\Opportunity $opportunity
     * @return Deliverable
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
     * Set higherEducationalInstitution
     *
     * @param \Provip\ProvipBundle\Entity\HigherEducationalInstitution $higherEducationalInstitution
     * @return Deliverable
     */
    public function setHigherEducationalInstitution(\Provip\ProvipBundle\Entity\HigherEducationalInstitution $higherEducationalInstitution = null)
    {
        $this->higherEducationalInstitution = $higherEducationalInstitution;
    
        return $this;
    }

    /**
     * Get higherEducationalInstitution
     *
     * @return \Provip\ProvipBundle\Entity\HigherEducationalInstitution 
     */
    public function getHigherEducationalInstitution()
    {
        return $this->higherEducationalInstitution;
    }

    /**
     * Add tasks
     *
     * @param \Provip\ProvipBundle\Entity\Task $tasks
     * @return Deliverable
     */
    public function addTask(\Provip\ProvipBundle\Entity\Task $tasks)
    {
        $this->tasks[] = $tasks;
    
        return $this;
    }

    /**
     * Remove tasks
     *
     * @param \Provip\ProvipBundle\Entity\Task $tasks
     */
    public function removeTask(\Provip\ProvipBundle\Entity\Task $tasks)
    {
        $this->tasks->removeElement($tasks);
    }

    /**
     * Get tasks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * @param mixed $enrollment
     */
    public function setEnrollment($enrollment)
    {
        $this->enrollment = $enrollment;
    }

    /**
     * @return mixed
     */
    public function getEnrollment()
    {
        return $this->enrollment;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }




}