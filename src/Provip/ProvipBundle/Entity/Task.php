<?php

namespace Provip\ProvipBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="tasks")
 */
class Task
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
     * @ORM\ManyToOne(targetEntity="Deliverable", inversedBy="tasks")
     * @ORM\JoinColumn(name="deliverable_id", referencedColumnName="id")
     * @Assert\Valid
     **/
    protected $deliverable;


    /**
     * @ORM\OneToMany(targetEntity="Activity", mappedBy="task")
     * @Assert\Valid
     */
    protected $activities;


}