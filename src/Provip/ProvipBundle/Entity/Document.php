<?php

namespace Provip\ProvipBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Provip\UserBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Gedmo\Mapping\Annotation as Gedmo;

class DocumentState
{
    const STATE_AWAITING_CROCODOC_UPLOAD = 'awaiting_crocodoc_upload';
    const STATE_UPLOADED_TO_CROCODOC = 'uploaded_to_crocodoc';
    const STATE_QUEUED = 'queued';
    const STATE_PROCESSING = 'processing';
    const STATE_DONE = 'done';
    const STATE_ERROR = 'error';
}

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="documents")
 */
class Document
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     *
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, unique=true)
     *
     * @var string
     */
    protected $crocodocId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    protected $path;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var bool
     */
    protected $viewable;

    /**
     * @Assert\NotBlank
     * @Assert\File(maxSize="5M", mimeTypes={"application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/vnd.ms-excel", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "application/vnd.ms-powerpoint", "application/vnd.openxmlformats-officedocument.presentationml.presentation", "application/pdf", "application/x-pdf"})
     *
     * @var UploadedFile
     */
    protected $file;

    /**
     * @var string
     */
    private $tempPath;

    /**
     * @ORM\ManyToOne(targetEntity="Provip\UserBundle\Entity\User")
     *
     * @var User
     */
    protected $owner;

    /**
     * @ORM\ManyToOne(targetEntity="Provip\ProvipBundle\Entity\Internship", inversedBy="documents")
     *
     * @var Internship
     **/
    protected $internship;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     *
     * @var string
     */
    protected $state;

    /**
     * @var datetime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->state = DocumentState::STATE_AWAITING_CROCODOC_UPLOAD;
        $this->viewable = false;
    }

    /**
     * @return null|string
     */
    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    /**
     * @return null|string
     */
    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }

    /**
     * @return string
     */
    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    /**
     * @return string
     */
    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up when displaying uploaded doc/image in the view.
        return 'uploads/documents';
    }

    /**
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        // check if we have an old image path
        if (isset($this->path)) {
            // store the old name to delete after the update
            $this->tempPath = $this->path;
            $this->path = null;
        } else {
            $this->path = 'initial';
        }
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $this->path = $filename.'.'.$this->file->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->file->move($this->getUploadRootDir(), $this->path);

        // check if we have an old file
        if (isset($this->tempPath)) {
            // delete the old file
            unlink($this->getUploadRootDir().'/'.$this->tempPath);
            // clear the temp file path
            $this->tempPath = null;
        }
        $this->file = null;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }

    /**
     * @param $crocodocId string
     */
    public function setCrocodocId($crocodocId)
    {
        $this->crocodocId = $crocodocId;
    }

    /**
     * @return string
     */
    public function getCrocodocId()
    {
        return $this->crocodocId;
    }

    /**
     * @param User $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param \Provip\ProvipBundle\Entity\Internship $internship
     */
    public function setInternship($internship)
    {
        $this->internship = $internship;
    }

    /**
     * @return \Provip\ProvipBundle\Entity\Internship
     */
    public function getInternship()
    {
        return $this->internship;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\File\UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param boolean $viewable
     */
    public function setViewable($viewable)
    {
        $this->viewable = $viewable;
    }

    /**
     * @return bool
     */
    public function isViewable()
    {
        return $this->state === DocumentState::STATE_DONE;
    }

    /**
     * @param \Provip\ProvipBundle\Entity\datetime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return \Provip\ProvipBundle\Entity\datetime
     */
    public function getCreated()
    {
        return $this->created;
    }


}