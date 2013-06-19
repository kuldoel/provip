<?php

namespace Provip\ProvipBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="enrollments")
 */
class Enrollment
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Default approved is false
     *
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     */
    protected $approved = false;


    /**
     * @ORM\ManyToOne(targetEntity="HigherEducationalInstitution", inversedBy="enrollments")
     * @ORM\JoinColumn(name="organization_id", referencedColumnName="id")
     * @Assert\Valid
     **/
    protected $organization;


}