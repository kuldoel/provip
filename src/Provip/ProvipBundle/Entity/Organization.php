<?php

namespace Provip\ProvipBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="organizations")
 *
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"company" = "Company", "hei" = "HigherEducationalInstitution"})
 *
 */
abstract class Organization
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
     * @Assert\String()
     */
    protected $name;

    /**
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\Country
     * @Assert\NotNull()
     */
    protected $country;

    /**
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     * @Assert\String()
     */
    protected $field;

    /**
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\Url()
     */
    protected $url;

    /**
     * @ORM\Column(length=255, unique=true)
     * @Gedmo\Slug(fields={"name"})
     */
    protected $slug;

    /**
     * Official Company Language
     *
     *
     * @ORM\OneToOne(targetEntity="Provip\ProvipBundle\Language")
     * @ORM\JoinColumn(name="shipping_id", referencedColumnName="id")
     *
     * @Assert\Valid
     */
    protected $language;

    /**
     * supportedLanguages is a collection of other languages spoken in this company
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
     * @ORM\OneToMany(targetEntity="Provip\UserBundle\User", mappedBy="organization")
    * @Assert\Valid
     */
    protected $staff;

}