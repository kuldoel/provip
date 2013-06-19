<?php

namespace Provip\ProvipBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="opportunities")
 */
class Opportunity
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
    protected $title;

    /**
     *
     * @ORM\Column(type="text")
     * @Assert\NotNull()
     * @Assert\Type(type="string")
     */
    protected $description;


    /**
     *
     * @ORM\Column(type="integer", length=12)
     * @Assert\NotNull()
     * @Assert\Type(type="int")
     */
    protected $nbrOfPositions;


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
     *
     * @ORM\Column(type="text")
     * @Assert\NotNull()
     * @Assert\Type(type="string")
     */
    protected $selectionProcedure;


    /**
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     * @Assert\Type(type="string")
     */
    protected $communicationProtocol;

    /**
     * @ORM\Column(length=255, unique=true)
     * @Gedmo\Slug(fields={"title"})
     */
    protected $slug;


    /**
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="opportunities")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     * @Assert\Valid
     **/
    protected $company;

    /**
     * @ORM\ManyToOne(targetEntity="Provip\UserBundle\Entity\User", inversedBy="mentoring")
     * @ORM\JoinColumn(name="mentor_id", referencedColumnName="id")
     * @Assert\Valid
     **/
    protected $mentor;

    /**
     * @ORM\OneToMany(targetEntity="Deliverable", mappedBy="opportunity")
     * @Assert\Valid
     */
    protected $projectGoals;

    /**
     * @ORM\OneToMany(targetEntity="Application", mappedBy="opportunity")
     * @Assert\Valid
     */
    protected $applications;

    /**
     * @ORM\ManyToMany(targetEntity="Skill", inversedBy="opportunities")
     * @ORM\JoinTable(name="opportunities_skills")
     **/
    protected $skills;


}