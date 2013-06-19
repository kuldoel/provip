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


}