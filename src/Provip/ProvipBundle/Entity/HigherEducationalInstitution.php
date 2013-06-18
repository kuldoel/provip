<?php

namespace Provip\ProvipBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 */
class HigherEducationalInstitution
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
     * @Assert\String()
     */
    protected $studyProgram;

    /**
     * @ORM\OneToMany(targetEntity="Skill", mappedBy="organization")
     * @Assert\Valid
     */
    protected $skills;

    /**
     * @ORM\OneToMany(targetEntity="Enrollment", mappedBy="organization")
     * @Assert\Valid
     */
    protected $enrollments;

    /**
     * @ORM\OneToMany(targetEntity="Deliverable", mappedBy="organization")
     * @Assert\Valid
     */
    protected $learningGoals;

}