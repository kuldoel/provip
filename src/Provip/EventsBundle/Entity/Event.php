<?php

namespace Provip\EventsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="events")
 *
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"activityupdate" = "ActivityUpdateEvent", "application" = "ApplicationEvent", "feedback" = "FeedbackEvent", "student" = "StudentEvent", "simpleevent" = "Event"})
 *
 */
class Event
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
    protected $message;

    /**
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     * @Assert\Type(type="string")
     */
    protected $privacy;

    /**
     * Optional Picture
     *
     *
     * @ORM\OneToOne(targetEntity="Picture")
     * @ORM\JoinColumn(name="picture_id", referencedColumnName="id")
     *
     * @Assert\Valid
     */
    protected $picture;


    /**
     * Optional Picture
     *
     *
     * @ORM\OneToOne(targetEntity="Provip\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="picture_id", referencedColumnName="id")
     *
     * @Assert\Valid
     */
    protected $author;

    /**
     * @var datetime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @var datetime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    protected $updated;



}