<?php

namespace Provip\ProvipBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Type(type="string")
     */
    protected $learningOutcomes;


    /**
     *
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Type(type="string")
     */
    protected $internshipMilestones;

    /**
     * @ORM\ManyToOne(targetEntity="HigherEducationalInstitution", inversedBy="studyPrograms", cascade={"persist"})
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
     * @ORM\OneToMany(targetEntity="Provip\UserBundle\Entity\User", mappedBy="teachesAt")
     * @Assert\Valid
     */
    protected $staff;

    /**
     * @ORM\ManyToMany(targetEntity="Provip\UserBundle\Entity\User", inversedBy="adminOf", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinTable(name="studyprogram_admins",
     *   joinColumns={
     *     @ORM\JoinColumn(name="studyProgram", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="user", referencedColumnName="id")
     *   }
     * )
     */
    protected $admins;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->skills = new ArrayCollection();
        $this->enrollments = new ArrayCollection();
        $this->staff = new ArrayCollection();
        $this->admins = new ArrayCollection();
    }

    /**
     * @param mixed $id
     *
     * @return StudyProgram
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }



    /**
     * Set studyProgram
     *
     * @param $hei
     *
     * @internal param string $studyProgram
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
     * @param Skill $skill
     *
     * @internal param \Provip\ProvipBundle\Entity\Skill $skills
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
     * @param Skill $skill
     *
     * @internal param \Provip\ProvipBundle\Entity\Skill $skills
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
     * @param Enrollment $enrollment
     *
     * @internal param \Provip\ProvipBundle\Entity\Enrollment $enrollments
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
     * @param Enrollment $enrollment
     *
     * @internal param \Provip\ProvipBundle\Entity\Enrollment $enrollments
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
     * @param mixed $admins
     *
     * @return StudyProgram
     */
    public function setAdmins($admins)
    {
        $this->admins = $admins;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAdmins()
    {
        return $this->admins ?: $this->admins = new ArrayCollection();
    }

    /**
     * @param $admin
     *
     * @internal param $user
     *
     * @return $this
     */
    public function addAdmin($admin)
    {
        if(!$this->getAdmins()->contains($admin))
        {
            $this->admins[] = $admin;
            $admin->addAdminOf($this);
        }

        return $this;
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

    /**
     * @param mixed $internshipMilestones
     */
    public function setInternshipMilestones($internshipMilestones)
    {
        $this->internshipMilestones = $internshipMilestones;
    }

    /**
     * @return mixed
     */
    public function getInternshipMilestones()
    {
        return $this->internshipMilestones;
    }

    public function getNameForDropdown() {
        return $this->name . ' ['. $this->higherEducationalInstitution .'] ';
    }
}