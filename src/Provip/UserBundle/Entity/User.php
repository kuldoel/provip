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
     * @Assert\String()
     */
    protected $firstName;
    
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     * @Assert\String()
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
     * @Assert\String()
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
     * @Assert\String()
     */
    protected $phone;

    /**
     * jobDescription is an attribute of StaffMember and is an optional field
     *
     *
     * @ORM\Column(type="text", nullable=true)
     * @Assert\String()
     */
    protected $jobDescription;

    /**
     * Language is an relation attribute of Student and is the native language of the Student
     *
     *
     * @ORM\OneToOne(targetEntity="Provip\ProvipBundle\Language")
     * @ORM\JoinColumn(name="shipping_id", referencedColumnName="id")
     * @Assert\Valid
     */
    protected $language;

    /**
     * supportedLanguages is an relation attribute of Student and are the other languages that the Student speaks
     *
     *
     * @ORM\ManyToMany(targetEntity="Provip\ProvipBundle\Language")
     * @ORM\JoinTable(name="users_supportedlanguages",
     *      joinColumns={@JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="language_id", referencedColumnName="id", unique=true)}
     *      )
     * @Assert\Valid
     */
    protected $supportedLanguages;

    /**
     * @ORM\ManyToOne(targetEntity="Provip\ProvipBundle\Organization", inversedBy="staff")
     * @ORM\JoinColumn(name="organization_id", referencedColumnName="id")
     * @Assert\Valid
     **/
    protected $organization;


}