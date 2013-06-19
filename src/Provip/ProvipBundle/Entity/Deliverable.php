<?php

namespace Provip\ProvipBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="deliverables")
 */
class Deliverable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *
     * @ORM\Column(type="text")
     * @Assert\NotNull()
     * @Assert\Type(type="string")
     */
    protected $description;

    /**
     * @ORM\ManyToOne(targetEntity="Opportunity", inversedBy="projectGoals")
     * @ORM\JoinColumn(name="opportunity_id", referencedColumnName="id")
     * @Assert\Valid
     **/
    protected $opportunity;


    /**
     * @ORM\ManyToOne(targetEntity="HigherEducationalInstitution", inversedBy="learningGoals")
     * @ORM\JoinColumn(name="hei_id", referencedColumnName="id")
     * @Assert\Valid
     **/
    protected $higherEducationalInstitution;


    /**
     * @ORM\OneToMany(targetEntity="Task", mappedBy="deliverable")
     * @Assert\Valid
     */
    protected $tasks;


}