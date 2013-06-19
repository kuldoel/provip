<?php

namespace Provip\ProvipBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 */
class Company extends Organization
{

    /**
     *
     * @ORM\Column(type="text")
     * @Assert\NotNull()
     * @Assert\Type(type="string")
     */
    protected $description;


    /**
     * @ORM\OneToMany(targetEntity="Opportunity", mappedBy="company")
     * @Assert\Valid
     */
    protected $opportunities;

}