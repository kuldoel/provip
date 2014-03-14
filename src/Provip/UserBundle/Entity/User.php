<?php

namespace Provip\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Provip\ProvipBundle\Entity\Activity;
use Provip\ProvipBundle\Entity\Company;
use Provip\ProvipBundle\Entity\Enrollment;
use Provip\ProvipBundle\Entity\HigherEducationalInstitution;
use Provip\ProvipBundle\Entity\Internship;
use Provip\ProvipBundle\Entity\Opportunity;
use Provip\ProvipBundle\Entity\StudyProgram;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="Provip\UserBundle\Repository\UserRepository")
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
     * @ORM\Column(type="string", length=7, nullable=true)
     * @Assert\Country
     */
    protected $nationality;

    /**
     * URL is an attribute of Student and it a link to their LinkedIn or other profile
     *
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Url
     */
    protected $url;

    /**
     * Phone is an attribute of StaffMember
     *
     *
     * @ORM\Column(type="string", length=20, nullable=true)
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
     * Default profileComplete is false
     *
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     */
    protected $profileComplete = false;

    /**
     * Language is a relation attribute of Student and is the native language of the Student
     *
     *
     * @ORM\ManyToOne(targetEntity="Provip\ProvipBundle\Entity\Language")
     * @ORM\JoinColumn(name="primarylanguage_id", referencedColumnName="id", unique=false)
     * @Assert\Valid
     */
    protected $language;

    /**
     * supportedLanguages is a relation attribute of Student and are the other languages that the Student speaks
     *
     *
     * @ORM\ManyToMany(targetEntity="Provip\ProvipBundle\Entity\Language")
     * @ORM\JoinTable(name="users_supportedlanguages",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="language_id", referencedColumnName="id")}
     *      )
     * @Assert\Valid
     */
    protected $supportedLanguages;

    /**
     * If a user is a member of staff of a Company they have a direct link to the company
     *
     *
     * @ORM\ManyToOne(targetEntity="Provip\ProvipBundle\Entity\Company", inversedBy="staff",cascade={"persist"})
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     **/
    protected $company;



    /**
     * If a user is a member of staff of a StudyProgram they have a direct link to the StudyProgram
     *
     *
     * @ORM\ManyToOne(targetEntity="Provip\ProvipBundle\Entity\StudyProgram", inversedBy="staff", cascade={"persist"})
     * @ORM\JoinColumn(name="studyprogram_id", referencedColumnName="id")
     * @Assert\Valid
     **/
    protected $teachesAt;

    /**
     * If a user is a Student they have an indirect link to a HEI using the Enrollment class.
     * An Enrollment is default set to false and has to be approved by the HEI
     *
     *
     * @ORM\OneToOne(targetEntity="Provip\ProvipBundle\Entity\Enrollment", inversedBy="student" , cascade={"persist", "remove"})
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
     * @ORM\OneToMany(targetEntity="Provip\ProvipBundle\Entity\Application", mappedBy="student", cascade={"persist", "remove"})
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
     * @ORM\OneToMany(targetEntity="Provip\EventsBundle\Entity\StudentEvent", mappedBy="student", cascade={"persist", "remove"})
     * @Assert\Valid
     */
    protected $studentEvents;

    /**
     * REDUNDANT LINK TO ACTIVITIES FOR PERFORMANCE
     *
     * @ORM\OneToMany(targetEntity="Provip\ProvipBundle\Entity\Activity", mappedBy="student", cascade={"persist", "remove"})
     */
    protected $activities;


    /**
     * Notifications is a list of all notifications for this user
     *
     * @ORM\OneToMany(targetEntity="Provip\EventsBundle\Entity\Notification", mappedBy="user", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "DESC"})
     * @Assert\Valid
     */
    protected $notifications;


    /**
     * Internships with application with the opportunity that a STUDENT applied for
     *
     * @ORM\OneToMany(targetEntity="Provip\ProvipBundle\Entity\Internship", mappedBy="student", cascade={"persist", "remove"})
     * @Assert\Valid
     */
    protected $internships;


    /**
    * Optional Picture
    *
    *
    * @ORM\OneToOne(targetEntity="Provip\EventsBundle\Entity\Picture",cascade={"persist", "remove"})
    * @ORM\JoinColumn(name="picture_id", referencedColumnName="id", nullable=true)
    */
    protected $picture;

    /**
     * @ORM\ManyToMany(targetEntity="Provip\ProvipBundle\Entity\StudyProgram", mappedBy="admins", fetch="EAGER")
     *
     */
    protected $adminOf;


    /**
     *
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Type(type="string")
     */
    protected $responsibleFor;


    /**
     * Constructor
     */
    public function __construct()
    {

        parent::__construct();

        $this->username = md5(crypt(rand(0, 50000).time()));
        $this->supportedLanguages = new ArrayCollection();
        $this->mentoring = new ArrayCollection();
        $this->applications = new ArrayCollection();
        $this->coaching = new ArrayCollection();
        $this->studentEvents = new ArrayCollection();
        $this->notifications = new ArrayCollection();
        $this->activities = new ArrayCollection();
        $this->internships = new ArrayCollection();
        $this->adminOf = new ArrayCollection();
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
     * @param \Provip\ProvipBundle\Entity\Language $supportedLanguage
     *
     * @internal param \Provip\ProvipBundle\Entity\Language $supportedLanguages
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
     * @param \Provip\ProvipBundle\Entity\Language $supportedLanguage
     *
     * @internal param \Provip\ProvipBundle\Entity\Language $supportedLanguages
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


    public function setCompany(Company $company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get Company
     *
     * @return \Provip\ProvipBundle\Entity\Company
     */
    public function getCompany()
    {
        return $this->company;
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
     * @param \Provip\ProvipBundle\Entity\Opportunity $opportunity
     *
     * @internal param \Provip\ProvipBundle\Entity\Opportunity $mentoring
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
     * @param \Provip\ProvipBundle\Entity\Opportunity $opportunity
     *
     * @internal param \Provip\ProvipBundle\Entity\Opportunity $mentoring
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
     * @param \Provip\ProvipBundle\Entity\Application $application
     *
     * @internal param \Provip\ProvipBundle\Entity\Application $applications
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
     * @param \Provip\ProvipBundle\Entity\Application $application
     *
     * @internal param \Provip\ProvipBundle\Entity\Application $applications
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
     * @param \Provip\ProvipBundle\Entity\Application $application
     *
     * @internal param \Provip\ProvipBundle\Entity\Application $coaching
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
     * @param \Provip\ProvipBundle\Entity\Application $application
     *
     * @internal param \Provip\ProvipBundle\Entity\Application $coaching
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
     * @param \Provip\EventsBundle\Entity\StudentEvent $studentEvent
     *
     * @internal param \Provip\EventsBundle\Entity\StudentEvent $studentEvents
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
     * @param \Provip\EventsBundle\Entity\StudentEvent $studentEvent
     *
     * @internal param \Provip\EventsBundle\Entity\StudentEvent $studentEvents
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
     * @param \Provip\EventsBundle\Entity\Notification $notification
     *
     * @internal param \Provip\EventsBundle\Entity\Notification $notifications
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
     * @param \Provip\EventsBundle\Entity\Notification $notification
     *
     * @internal param \Provip\EventsBundle\Entity\Notification $notifications
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

    public function getHei()
    {
        if($this->enrollment instanceof Enrollment)
        {
            return $this->enrollment->getStudyProgram()->getHigherEducationalInstitution();
        }
        else{
            return null;
        }
    }

    public function setHei(HigherEducationalInstitution $hei)
    {
        return $this;
    }

    public function setStudyProgram(StudyProgram $sp)
    {
        $this->setEnrollment(new Enrollment($sp));

        return $this;
    }

    public function getStudyProgram()
    {
        if($this->enrollment instanceof Enrollment)
        {
            return $this->getEnrollment()->getStudyProgram();
        }
        else
        {
            return null;
        }
    }



    /**
     * @param mixed $profileComplete
     */
    public function setProfileComplete($profileComplete)
    {
        $this->profileComplete = $profileComplete;
    }

    /**
     * @return mixed
     */
    public function getProfileComplete()
    {
        return $this->profileComplete;
    }

    /**
     * __toString()
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    /**
     * @param mixed $teachesAt
     */
    public function setTeachesAt($teachesAt)
    {
        $this->teachesAt = $teachesAt;
    }

    /**
     * @return mixed
     */
    public function getTeachesAt()
    {
        return $this->teachesAt;
    }

    /**
     * @param mixed $adminOf
     */
    public function setAdminOf($adminOf)
    {
        $this->adminOf = $adminOf;
    }

    /**
     * @return mixed
     */
    public function getAdminOf()
    {
        return $this->adminOf ?: $this->adminOf = new ArrayCollection();
    }

    /**
     * @param $studyProgram
     *
     * @return $this
     * @internal param mixed $adminOf
     */
    public function addAdminOf($studyProgram)
    {
        if(!$this->getAdminOf()->contains($studyProgram))
        {
            $this->adminOf[] = $studyProgram;
            $studyProgram->addAdmin($this);
        }

        return $this;
    }

    /**
     * @param mixed $activities
     */
    public function setActivities($activities)
    {
        $this->activities = $activities;
    }

    /**
     * @return mixed
     */
    public function getActivities()
    {
        return $this->activities;
    }

    public function addActivity(Activity $activity)
    {
        $this->activities[] = $activity;

        return $this;
    }

    public function removeActivity(Activity $activity)
    {
        $this->activities->removeElement($activity);

        return $this;
    }

    public function getApplicationForOpportunity(Opportunity $opportunity)
    {
        $applications = $this->applications;

        foreach($applications as $app)
        {
            if($app->getOpportunity() == $opportunity)
            {
                return $app;
            }
        }

        return false;
    }

    /**
     * @param mixed $internships
     */
    public function setInternships($internships)
    {
        $this->internships = $internships;
    }

    /**
     * @return mixed
     */
    public function getInternships()
    {
        return $this->internships;
    }

    /**
     * @param mixed $responsibleFor
     */
    public function setResponsibleFor($responsibleFor)
    {
        $this->responsibleFor = $responsibleFor;
    }

    /**
     * @return mixed
     */
    public function getResponsibleFor()
    {
        return $this->responsibleFor;
    }

    public function getCurrentInternship()
    {
        if(! $this->internships || $this->internships->isEmpty()){
            return null;
        }

        foreach($this->internships as $internship){
            if(! $internship->getCompleted()){
                return $internship;
            }
        }

        return $this->internships->last();
    }


}