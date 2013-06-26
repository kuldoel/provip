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
    protected $valueAttr;


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
     * Set key
     *
     * @param string $key
     * @return Language
     */
    public function setKey($key)
    {
        $this->key = $key;
    
        return $this;
    }

    /**
     * Get key
     *
     * @return string 
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return Language
     */
    public function setValueAttr($valueAttr)
    {
        $this->valueAttr = $valueAttr;
    
        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValueAttr()
    {
        return $this->valueAttr;
    }

    public function __toString()
    {
        return $this->valueAttr;
    }
}