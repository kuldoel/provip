<?php

namespace Provip\ProvipBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="internships")
 */
class Internship
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
    protected $publicId;


    /**
     * Default completed is false
     *
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     */
    protected $completed = false;

    /**
     *
     * @ORM\OneToOne(targetEntity="Application")
     * @ORM\JoinColumn(name="application_id", referencedColumnName="id")
     * @Assert\Valid
     */
    protected $application;

}