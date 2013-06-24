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
     * @ORM\OneToMany(targetEntity="StudyProgram", mappedBy="higherEducationalInstitution")
     * @Assert\Valid
     */
    protected $studyPrograms;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->studyPrograms = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add studyPrograms
     *
     * @param \Provip\ProvipBundle\Entity\StudyProgram $studyPrograms
     * @return HigherEducationalInstitution
     */
    public function addStudyProgram(\Provip\ProvipBundle\Entity\StudyProgram $studyPrograms)
    {
        $this->studyPrograms[] = $studyPrograms;
    
        return $this;
    }

    /**
     * Remove studyPrograms
     *
     * @param \Provip\ProvipBundle\Entity\StudyProgram $studyPrograms
     */
    public function removeStudyProgram(\Provip\ProvipBundle\Entity\StudyProgram $studyPrograms)
    {
        $this->studyPrograms->removeElement($studyPrograms);
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
}