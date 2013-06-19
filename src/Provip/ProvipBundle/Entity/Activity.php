<?php

namespace Provip\ProvipBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="activities")
 */
class Activity
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
     * @ORM\Column(type="datetime")
     * @Assert\NotNull()
     * @Assert\DateTime()
     */
    protected $deadline;

    /**
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     * @Assert\Type(type="string")
     */
    protected $state;

    /**
     *
     * @ORM\Column(type="integer", length=12)
     * @Assert\NotNull()
     * @Assert\Type(type="int")
     */
    protected $nbrOfOccurrences;

    /**
     * @ORM\ManyToOne(targetEntity="Task", inversedBy="activities")
     * @ORM\JoinColumn(name="task_id", referencedColumnName="id")
     * @Assert\Valid
     **/
    protected $task;

    /**
     * @ORM\ManyToOne(targetEntity="Application", inversedBy="charter")
     * @ORM\JoinColumn(name="application_id", referencedColumnName="id")
     * @Assert\Valid
     **/
    protected $application;

    /**
     * @ORM\OneToMany(targetEntity="Provip\EventsBundle\Entity\ActivityUpdateEvent", mappedBy="activity")
     * @Assert\Valid
     */
    protected $activityUpdateEvents;


}