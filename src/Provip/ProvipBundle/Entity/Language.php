<?php

namespace Provip\ProvipBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="languages")
 */
class Language
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * This is the language key which follows the language id ISO norm.
     * This is assured by the Language assert which is available is Symfony
     *
     * @ORM\Column(type="string", length=7)
     * @Assert\NotNull()
     * @Assert\Language
     */
    protected $key;

    /**
     * This is the English word for the language as it will be displayed in the front-end
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     * @Assert\Type(type="string")
     */
    protected $value;

}