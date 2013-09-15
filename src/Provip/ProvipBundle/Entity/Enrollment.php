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
     * Default denied is false
     *
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     */
    protected $denied = false;


    /**
     * @ORM\ManyToOne(targetEntity="StudyProgram", inversedBy="enrollments")
     * @ORM\JoinColumn(name="studyprogram_id", referencedColumnName="id")
     * @Assert\Valid
     **/
    protected $studyProgram;

    /**
     * @ORM\OneToOne(targetEntity="Provip\UserBundle\Entity\User", mappedBy="enrollment")
     */
    protected $student;

    /**
     * @ORM\OneToMany(targetEntity="Deliverable", mappedBy="enrollment", cascade={"persist", "remove"})
     */
    protected $deliverables;


    function __construct(StudyProgram $studyProgram)
    {
        $this->studyProgram = $studyProgram;
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
     * @param \Provip\ProvipBundle\Entity\StudyProgram $studyProgram
     * @return Enrollment
     */
    public function setStudyProgram(\Provip\ProvipBundle\Entity\StudyProgram $studyProgram = null)
    {
        $this->studyProgram = $studyProgram;
    
        return $this;
    }

    /**
     * Get organization
     *
     * @return \Provip\ProvipBundle\Entity\StudyProgram
     */
    public function getStudyProgram()
    {
        return $this->studyProgram;
    }

    /**
     * @param mixed $student
     */
    public function setStudent($student)
    {
        $this->student = $student;
    }

    /**
     * @return mixed
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * @param mixed $denied
     */
    public function setDenied($denied)
    {
        $this->denied = $denied;
    }

    /**
     * @return mixed
     */
    public function getDenied()
    {
        return $this->denied;
    }

    /**
     * @param mixed $deliverables
     */
    public function setDeliverables($deliverables)
    {
        $this->deliverables = $deliverables;
    }

    /**
     * @return mixed
     */
    public function getDeliverables()
    {
        return $this->deliverables;
    }

    function __toString()
    {
       return $this->getStudent()->getFullName();
    }


}