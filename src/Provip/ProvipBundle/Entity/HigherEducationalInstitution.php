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

}