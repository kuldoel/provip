<?php

namespace Provip\ProvipBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="studyprograms")
 */
class StudyProgram
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
    protected $name;

    /**
     *
     * @ORM\Column(type="text")
     * @Assert\NotNull()
     * @Assert\Type(type="string")
     */
    protected $learningOutcomes;

    /**
     * @ORM\ManyToOne(targetEntity="HigherEducationalInstitution", inversedBy="studyPrograms")
     * @ORM\JoinColumn(name="hei_id", referencedColumnName="id")
     * @Assert\Valid
     **/
    protected $higherEducationalInstitution;

    /**
     * @ORM\ManyToMany(targetEntity="Skill", inversedBy="studyPrograms")
     * @ORM\JoinTable(name="studyprogram_skills")
     **/
    protected $skills;

    /**
     * @ORM\OneToMany(targetEntity="Enrollment", mappedBy="studyProgram")
     * @Assert\Valid
     */
    protected $enrollments;

    /**
     * @ORM\OneToMany(targetEntity="Deliverable", mappedBy="studyProgram")
     * @Assert\Valid
     */
    protected $learningGoals;

    /**
     * @ORM\OneToMany(targetEntity="Provip\UserBundle\Entity\User", mappedBy="teachesAt")
     * @Assert\Valid
     */
    protected $staff;

    /**
     * @ORM\OneToOne(targetEntity="Provip\UserBundle\Entity\User", mappedBy="adminOf")
     */
    protected $admin;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->skills = new \Doctrine\Common\Collections\ArrayCollection();
        $this->enrollments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->learningGoals = new \Doctrine\Common\Collections\ArrayCollection();
        $this->staff = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set studyProgram
     *
     * @param string $studyProgram
     * @return HigherEducationalInstitution
     */
    public function setHigherEducationalInstitution($hei)
    {
        $this->higherEducationalInstitution = $hei;
    
        return $this;
    }

    /**
     * Get studyProgram
     *
     * @return string 
     */
    public function getHigherEducationalInstitution()
    {
        return $this->higherEducationalInstitution;
    }

    /**
     * Add skills
     *
     * @param \Provip\ProvipBundle\Entity\Skill $skills
     * @return HigherEducationalInstitution
     */
    public function addSkill(\Provip\ProvipBundle\Entity\Skill $skill)
    {
        $this->skills[] = $skill;
    
        return $this;
    }

    /**
     * Remove skills
     *
     * @param \Provip\ProvipBundle\Entity\Skill $skills
     */
    public function removeSkill(\Provip\ProvipBundle\Entity\Skill $skill)
    {
        $this->skills->removeElement($skill);
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
     * Add enrollments
     *
     * @param \Provip\ProvipBundle\Entity\Enrollment $enrollments
     * @return HigherEducationalInstitution
     */
    public function addEnrollment(\Provip\ProvipBundle\Entity\Enrollment $enrollment)
    {
        $this->enrollments[] = $enrollment;
    
        return $this;
    }

    /**
     * Remove enrollments
     *
     * @param \Provip\ProvipBundle\Entity\Enrollment $enrollments
     */
    public function removeEnrollment(\Provip\ProvipBundle\Entity\Enrollment $enrollment)
    {
        $this->enrollments->removeElement($enrollment);
    }

    /**
     * Get enrollments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEnrollments()
    {
        return $this->enrollments;
    }

    /**
     * Add learningGoals
     *
     * @param \Provip\ProvipBundle\Entity\Deliverable $learningGoals
     * @return HigherEducationalInstitution
     */
    public function addLearningGoal(\Provip\ProvipBundle\Entity\Deliverable $learningGoal)
    {
        $this->learningGoals[] = $learningGoal;
    
        return $this;
    }

    /**
     * Remove learningGoals
     *
     * @param \Provip\ProvipBundle\Entity\Deliverable $learningGoals
     */
    public function removeLearningGoal(\Provip\ProvipBundle\Entity\Deliverable $learningGoal)
    {
        $this->learningGoals->removeElement($learningGoal);
    }

    /**
     * Get learningGoals
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLearningGoals()
    {
        return $this->learningGoals;
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

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }


    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @param mixed $admin
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;
    }

    /**
     * @return mixed
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * @param mixed $learningOutcomes
     */
    public function setLearningOutcomes($learningOutcomes)
    {
        $this->learningOutcomes = $learningOutcomes;
    }

    /**
     * @return mixed
     */
    public function getLearningOutcomes()
    {
        return $this->learningOutcomes;
    }





}