<?php

namespace Provip\ApplicationBundle\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Provip\ProvipBundle\Entity\Document;
use Provip\ProvipBundle\Entity\DocumentState;
use Provip\UserBundle\Entity\User;

class ProvipCrocodocService
{
    private $crocodocService;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param CrocodocService $crocodocService
     * @param EntityManager $entityManager
     */
    public function __construct($crocodocService, EntityManager $entityManager)
    {
        $this->crocodocService = $crocodocService;
        $this->entityManager = $entityManager;
    }

    /**
     * @param Document $document
     * @return string
     */
    public function uploadDocument(Document $document)
    {
        $docId = $this->crocodocService->uploadDocument($document->getAbsolutePath());
        if($docId){
            $document->setCrocodocId($docId);
            $document->setState(DocumentState::STATE_UPLOADED_TO_CROCODOC);
            $this->entityManager->persist($document);
            $this->entityManager->flush($document);
        }
    }

    /**
     * @param User $user
     * @param Document $document
     * @return string
     * @throws \LogicException
     *          Unauthorized user.
     */
    public function createSession(User $user, Document $document)
    {
        $authorized = false;

        if($user){
            if($document->getOwner() == $user){
                $authorized = true;
            }
            if($document->getInternship()->getHeiCoach() == $user){
                $authorized = true;
            }
            if($document->getInternship()->getCompany()->isStaffMember($user)){
                $authorized = true;
            }
        }

        if (! $authorized){
            throw new \LogicException('Unauthorized user');
        }

        return $this->crocodocService->createSession($document->getCrocodocId(), array(
            'isEditable' => true,
            'user' => array(
                'id' => $user->getId(),
                'name' => $user->getFullName(),
            ),
            'filter' => 'all',
            'isAdmin' => false,
            'isDownloadable' => true,
            'isCopyprotected' => false,
            'isDemo' => false,
            'sidebar' => 'auto'
        ));
    }

    /**
     * @param ArrayCollection|Document[] $documents
     * @return array
     */
    public function getStatusForDocuments(ArrayCollection $documents)
    {
        $docIds = array();

        foreach ($documents as $document){
            if ($document->getCrocodocId()){
                array_push($docIds, $document->getCrocodocId());
            }
        }

        return $this->crocodocService->getStatus($docIds);
    }

    /**
     * @param Document $document
     * @return array|null
     */
    public function getStatusForSingleDocument(Document $document)
    {
        if(! $document->getCrocodocId())
        {
            return null;
        }

        return $this->crocodocService->getStatus($document->getCrocodocId());
    }
}