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


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->activities = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Task
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Task
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set deadline
     *
     * @param \DateTime $deadline
     * @return Task
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;
    
        return $this;
    }

    /**
     * Get deadline
     *
     * @return \DateTime 
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * Set deliverable
     *
     * @param \Provip\ProvipBundle\Entity\Deliverable $deliverable
     * @return Task
     */
    public function setDeliverable(\Provip\ProvipBundle\Entity\Deliverable $deliverable = null)
    {
        $this->deliverable = $deliverable;
    
        return $this;
    }

    /**
     * Get deliverable
     *
     * @return \Provip\ProvipBundle\Entity\Deliverable 
     */
    public function getDeliverable()
    {
        return $this->deliverable;
    }

    /**
     * Add activities
     *
     * @param \Provip\ProvipBundle\Entity\Activity $activities
     * @return Task
     */
    public function addActivitie(\Provip\ProvipBundle\Entity\Activity $activities)
    {
        $this->activities[] = $activities;
    
        return $this;
    }

    /**
     * Remove activities
     *
     * @param \Provip\ProvipBundle\Entity\Activity $activities
     */
    public function removeActivitie(\Provip\ProvipBundle\Entity\Activity $activities)
    {
        $this->activities->removeElement($activities);
    }

    /**
     * Get activities
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getActivities()
    {
        return $this->activities;
    }
}