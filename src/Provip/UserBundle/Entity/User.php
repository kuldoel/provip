<?php

namespace Provip\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     * @Assert\Type(type="string")
     */
    protected $firstName;
    
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     * @Assert\Type(type="string")
     */
    protected $lastName;

    /**
     * @ORM\Column(length=255, unique=true)
     * @Gedmo\Slug(fields={"firstName", "lastName"})
     */
    protected $slug;

    /**
     * Mission Statement is an attribute of Student and is an optional text field
     *
     *
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Type(type="string")
     */
    protected $missionStatement;

    /**
     * Nationality is an attribute of Student and follows the Country ISO Code
     *
     *
     * @ORM\Column(type="string", length=7)
     * @Assert\Country
     */
    protected $nationality;

    /**
     * URL is an attribute of Student and it a link to their LinkedIn or other profile
     *
     *
     * @ORM\Column(type="string", length=7)
     * @Assert\Url()
     */
    protected $url;

    /**
     * Phone is an attribute of StaffMember
     *
     *
     * @ORM\Column(type="string", length=20)
     * @Assert\Type(type="string")
     */
    protected $phone;

    /**
     * jobDescription is an attribute of StaffMember and is an optional field
     *
     *
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Type(type="string")
     */
    protected $jobDescription;

    /**
     * Language is an relation attribute of Student and is the native language of the Student
     *
     *
     * @ORM\OneToOne(targetEntity="Provip\ProvipBundle\Entity\Language")
     * @ORM\JoinColumn(name="shipping_id", referencedColumnName="id")
     * @Assert\Valid
     */
    protected $language;

    /**
     * supportedLanguages is an relation attribute of Student and are the other languages that the Student speaks
     *
     *
     * @ORM\ManyToMany(targetEntity="Provip\ProvipBundle\Entity\Language")
     * @ORM\JoinTable(name="users_supportedlanguages",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="language_id", referencedColumnName="id", unique=true)}
     *      )
     * @Assert\Valid
     */
    protected $supportedLanguages;

    /**
     * If a user is a member of staff of a HEI or Company they have a direct link to the company
     *
     *
     * @ORM\ManyToOne(targetEntity="Provip\ProvipBundle\Entity\Organization", inversedBy="staff")
     * @ORM\JoinColumn(name="organization_id", referencedColumnName="id")
     * @Assert\Valid
     **/
    protected $organization;

    /**
     * If a user is a Student they have a indirect link to a HEI using the Enrollment class.
     * An Enrollment is default set to false and has to be approved by the HEI
     *
     *
     * @ORM\OneToOne(targetEntity="Provip\ProvipBundle\Entity\Enrollment")
     * @ORM\JoinColumn(name="enrollment_id", referencedColumnName="id")
     * @Assert\Valid
     */
    protected $enrollment;


    /**
     * Mentoring is the list of opportunities that a COMPANY staff member is mentoring
     *
     * @ORM\OneToMany(targetEntity="Provip\ProvipBundle\Entity\Opportunity", mappedBy="mentor")
     * @Assert\Valid
     */
    protected $mentoring;

    /**
     * Applications is the list of applications with the opportunity that a STUDENT applied for
     *
     * @ORM\OneToMany(targetEntity="Provip\ProvipBundle\Entity\Application", mappedBy="student")
     * @Assert\Valid
     */
    protected $applications;

    /**
     * Coaching is  the list of internships that a HEI staff member is coaching
     *
     *
     * @ORM\OneToMany(targetEntity="Provip\ProvipBundle\Entity\Application", mappedBy="coach")
     * @Assert\Valid
     */
    protected $coaching;


    /**
     * studentsEvents is an list of all events involving the student as actor (can be both author and actor!)
     *
     * @ORM\OneToMany(targetEntity="Provip\EventsBundle\Entity\StudentEvent", mappedBy="student")
     * @Assert\Valid
     */
    protected $studentEvents;


    /**
     * Notifications is a list of all notifications for this user
     *
     * @ORM\OneToMany(targetEntity="Provip\EventsBundle\Entity\Notification", mappedBy="user")
     * @Assert\Valid
     */
    protected $notifications;


    /**
    * Optional Picture
    *
    *
    * @ORM\OneToOne(targetEntity="Provip\EventsBundle\Entity\Picture")
    * @ORM\JoinColumn(name="picture_id", referencedColumnName="id")
    *
    * @Assert\Valid
    */
    protected $picture;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->supportedLanguages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->mentoring = new \Doctrine\Common\Collections\ArrayCollection();
        $this->applications = new \Doctrine\Common\Collections\ArrayCollection();
        $this->coaching = new \Doctrine\Common\Collections\ArrayCollection();
        $this->studentEvents = new \Doctrine\Common\Collections\ArrayCollection();
        $this->notifications = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    
        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    
        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return User
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set missionStatement
     *
     * @param string $missionStatement
     * @return User
     */
    public function setMissionStatement($missionStatement)
    {
        $this->missionStatement = $missionStatement;
    
        return $this;
    }

    /**
     * Get missionStatement
     *
     * @return string 
     */
    public function getMissionStatement()
    {
        return $this->missionStatement;
    }

    /**
     * Set nationality
     *
     * @param string $nationality
     * @return User
     */
    public function setNationality($nationality)
    {
        $this->nationality = $nationality;
    
        return $this;
    }

    /**
     * Get nationality
     *
     * @return string 
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return User
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    
        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set jobDescription
     *
     * @param string $jobDescription
     * @return User
     */
    public function setJobDescription($jobDescription)
    {
        $this->jobDescription = $jobDescription;
    
        return $this;
    }

    /**
     * Get jobDescription
     *
     * @return string 
     */
    public function getJobDescription()
    {
        return $this->jobDescription;
    }

    /**
     * Set language
     *
     * @param \Provip\ProvipBundle\Entity\Language $language
     * @return User
     */
    public function setLanguage(\Provip\ProvipBundle\Entity\Language $language = null)
    {
        $this->language = $language;
    
        return $this;
    }

    /**
     * Get language
     *
     * @return \Provip\ProvipBundle\Entity\Language 
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Add supportedLanguages
     *
     * @param \Provip\ProvipBundle\Entity\Language $supportedLanguages
     * @return User
     */
    public function addSupportedLanguage(\Provip\ProvipBundle\Entity\Language $supportedLanguage)
    {
        $this->supportedLanguages[] = $supportedLanguage;
    
        return $this;
    }

    /**
     * Remove supportedLanguages
     *
     * @param \Provip\ProvipBundle\Entity\Language $supportedLanguages
     */
    public function removeSupportedLanguage(\Provip\ProvipBundle\Entity\Language $supportedLanguage)
    {
        $this->supportedLanguages->removeElement($supportedLanguage);
    }

    /**
     * Get supportedLanguages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSupportedLanguages()
    {
        return $this->supportedLanguages;
    }

    /**
     * Set organization
     *
     * @param \Provip\ProvipBundle\Entity\Organization $organization
     * @return User
     */
    public function setOrganization(\Provip\ProvipBundle\Entity\Organization $organization = null)
    {
        $this->organization = $organization;
    
        return $this;
    }

    /**
     * Get organization
     *
     * @return \Provip\ProvipBundle\Entity\Organization 
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * Set enrollment
     *
     * @param \Provip\ProvipBundle\Entity\Enrollment $enrollment
     * @return User
     */
    public function setEnrollment(\Provip\ProvipBundle\Entity\Enrollment $enrollment = null)
    {
        $this->enrollment = $enrollment;
    
        return $this;
    }

    /**
     * Get enrollment
     *
     * @return \Provip\ProvipBundle\Entity\Enrollment 
     */
    public function getEnrollment()
    {
        return $this->enrollment;
    }

    /**
     * Add mentoring
     *
     * @param \Provip\ProvipBundle\Entity\Opportunity $mentoring
     * @return User
     */
    public function addMentoring(\Provip\ProvipBundle\Entity\Opportunity $opportunity)
    {
        $this->mentoring[] = $opportunity;
    
        return $this;
    }

    /**
     * Remove mentoring
     *
     * @param \Provip\ProvipBundle\Entity\Opportunity $mentoring
     */
    public function removeMentoring(\Provip\ProvipBundle\Entity\Opportunity $opportunity)
    {
        $this->mentoring->removeElement($opportunity);
    }

    /**
     * Get mentoring
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMentoring()
    {
        return $this->mentoring;
    }

    /**
     * Add applications
     *
     * @param \Provip\ProvipBundle\Entity\Application $applications
     * @return User
     */
    public function addApplication(\Provip\ProvipBundle\Entity\Application $application)
    {
        $this->applications[] = $application;
    
        return $this;
    }

    /**
     * Remove applications
     *
     * @param \Provip\ProvipBundle\Entity\Application $applications
     */
    public function removeApplication(\Provip\ProvipBundle\Entity\Application $application)
    {
        $this->applications->removeElement($application);
    }

    /**
     * Get applications
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getApplications()
    {
        return $this->applications;
    }

    /**
     * Add coaching
     *
     * @param \Provip\ProvipBundle\Entity\Application $coaching
     * @return User
     */
    public function addCoaching(\Provip\ProvipBundle\Entity\Application $application)
    {
        $this->coaching[] = $application;
    
        return $this;
    }

    /**
     * Remove coaching
     *
     * @param \Provip\ProvipBundle\Entity\Application $coaching
     */
    public function removeCoaching(\Provip\ProvipBundle\Entity\Application $application)
    {
        $this->coaching->removeElement($application);
    }

    /**
     * Get coaching
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCoaching()
    {
        return $this->coaching;
    }

    /**
     * Add studentEvents
     *
     * @param \Provip\EventsBundle\Entity\StudentEvent $studentEvents
     * @return User
     */
    public function addStudentEvent(\Provip\EventsBundle\Entity\StudentEvent $studentEvent)
    {
        $this->studentEvents[] = $studentEvent;
    
        return $this;
    }

    /**
     * Remove studentEvents
     *
     * @param \Provip\EventsBundle\Entity\StudentEvent $studentEvents
     */
    public function removeStudentEvent(\Provip\EventsBundle\Entity\StudentEvent $studentEvent)
    {
        $this->studentEvents->removeElement($studentEvent);
    }

    /**
     * Get studentEvents
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStudentEvents()
    {
        return $this->studentEvents;
    }

    /**
     * Add notifications
     *
     * @param \Provip\EventsBundle\Entity\Notification $notifications
     * @return User
     */
    public function addNotification(\Provip\EventsBundle\Entity\Notification $notification)
    {
        $this->notifications[] = $notification;
    
        return $this;
    }

    /**
     * Remove notifications
     *
     * @param \Provip\EventsBundle\Entity\Notification $notifications
     */
    public function removeNotification(\Provip\EventsBundle\Entity\Notification $notification)
    {
        $this->notifications->removeElement($notification);
    }

    /**
     * Get notifications
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * Set picture
     *
     * @param \Provip\EventsBundle\Entity\Picture $picture
     * @return User
     */
    public function setPicture(\Provip\EventsBundle\Entity\Picture $picture = null)
    {
        $this->picture = $picture;
    
        return $this;
    }

    /**
     * Get picture
     *
     * @return \Provip\EventsBundle\Entity\Picture 
     */
    public function getPicture()
    {
        return $this->picture;
    }
}