<?php

namespace Provip\ProvipBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Provip\UserBundle\Entity\User;
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
     * @ORM\OneToOne(targetEntity="Application", mappedBy="internship")
     * @Assert\Valid
     */
    protected $application;


    /**
     * @ORM\ManyToOne(targetEntity="Provip\UserBundle\Entity\User", inversedBy="internships")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     * @Assert\Valid
     **/
    protected $student;

    /**
     *
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Type(type="string")
     */
    protected $commentsByStudent;

    /**
     *
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Type(type="string")
     */
    protected $commentsByHei;

    /**
     *
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Type(type="string")
     */
    protected $commentsByCompany;



    public function __construct(User $student, Application $application)
    {
        $this->student = $student;
        $this->application = $application;
        $this->publicId = $application->getStartDate()->format("dmY").$application->getEndDate()->format("dmY").$application->getId().$student->getSlug();
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
     * @param mixed $commentsByCompany
     */
    public function setCommentsByCompany($commentsByCompany)
    {
        $this->commentsByCompany = $commentsByCompany;
    }

    /**
     * @return mixed
     */
    public function getCommentsByCompany()
    {
        return $this->commentsByCompany;
    }

    /**
     * @param mixed $commentsByHei
     */
    public function setCommentsByHei($commentsByHei)
    {
        $this->commentsByHei = $commentsByHei;
    }

    /**
     * @return mixed
     */
    public function getCommentsByHei()
    {
        return $this->commentsByHei;
    }

    /**
     * @param mixed $commentsByStudent
     */
    public function setCommentsByStudent($commentsByStudent)
    {
        $this->commentsByStudent = $commentsByStudent;
    }

    /**
     * @return mixed
     */
    public function getCommentsByStudent()
    {
        return $this->commentsByStudent;
    }




}