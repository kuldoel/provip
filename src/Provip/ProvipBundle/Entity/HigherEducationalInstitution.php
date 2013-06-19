<?php

namespace Provip\ProvipBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 */
class HigherEducationalInstitution extends Organization
{

    /**
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     * @Assert\Type(type="string")
     */
    protected $studyProgram;

    /**
     * @ORM\ManyToMany(targetEntity="Skill", inversedBy="higherEducationalInstitutions")
     * @ORM\JoinTable(name="heis_skills")
     **/
    protected $skills;

    /**
     * @ORM\OneToMany(targetEntity="Enrollment", mappedBy="organization")
     * @Assert\Valid
     */
    protected $enrollments;

    /**
     * @ORM\OneToMany(targetEntity="Deliverable", mappedBy="higherEducationalInstitution")
     * @Assert\Valid
     */
    protected $learningGoals;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->skills = new \Doctrine\Common\Collections\ArrayCollection();
        $this->enrollments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->learningGoals = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set studyProgram
     *
     * @param string $studyProgram
     * @return HigherEducationalInstitution
     */
    public function setStudyProgram($studyProgram)
    {
        $this->studyProgram = $studyProgram;
    
        return $this;
    }

    /**
     * Get studyProgram
     *
     * @return string 
     */
    public function getStudyProgram()
    {
        return $this->studyProgram;
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

}