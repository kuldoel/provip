<?php

namespace Provip\ProvipBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="applications")
 */
class Application
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

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
     * Default submittedForReview is false
     *
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     */
    protected $submittedForReview = false;

    /**
     * Default approvedByCompany is false
     *
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     */
    protected $approvedByCompany = false;

    /**
     * Default approvedByHei is false
     *
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     */
    protected $approvedByHei = false;

    /**
     * Default rejected is false
     *
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     */
    protected $rejected = false;

    /**
     *
     * @ORM\Column(type="text")
     * @Assert\NotNull()
     * @Assert\Type(type="string")
     */
    protected $rejectionReason;


    /**
     * @ORM\ManyToOne(targetEntity="Provip\UserBundle\Entity\User", inversedBy="applications")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     * @Assert\Valid
     **/
    protected $student;

    /**
     * When the STUDENT applies for an internship they have to select a member of STAFF of their HEI which will be the
     * HEI contact person for this internship
     *
     *
     * @ORM\ManyToOne(targetEntity="Provip\UserBundle\Entity\User", inversedBy="coaching")
     * @ORM\JoinColumn(name="coach_id", referencedColumnName="id")
     * @Assert\Valid
     **/
    protected $coach;

    /**
     * @ORM\ManyToOne(targetEntity="Opportunity", inversedBy="applications")
     * @ORM\JoinColumn(name="opportunity_id", referencedColumnName="id")
     * @Assert\Valid
     **/
    protected $opportunity;

    /**
     * @ORM\OneToMany(targetEntity="Activity", mappedBy="application")
     * @Assert\Valid
     */
    protected $charter;

    /**
     *
     * @ORM\OneToOne(targetEntity="Organization")
     * @ORM\JoinColumn(name="rejectedby_id", referencedColumnName="id")
     * @Assert\Valid
     */
    protected $rejectedBy;


    /**
     * @ORM\OneToMany(targetEntity="Provip\EventsBundle\Entity\ApplicationEvent", mappedBy="application")
     * @Assert\Valid
     */
    protected $applicationEvents;


}