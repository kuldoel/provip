<?php

namespace Provip\ProvipBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="skills")
 */
class Skill
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * This is the English word for the skill
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     * @Assert\String()
     */
    protected $value;

    /**
     * @ORM\Column(length=255, unique=true)
     * @Gedmo\Slug(fields={"value"})
     */
    protected $slug;

    /**
     * @ManyToOne(targetEntity="HigherEducationalInstitution", inversedBy="skills")
     * @JoinColumn(name="organization_id", referencedColumnName="id")
     * @Assert\Valid
     **/
    protected $organization;


}