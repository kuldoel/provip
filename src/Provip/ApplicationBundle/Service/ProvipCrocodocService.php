<?php

namespace Provip\ApplicationBundle\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Provip\ProvipBundle\Entity\Document;
use Provip\UserBundle\Entity\User;

class ProvipCrocodocService
{
    /**
     * @var CrocodocService
     */
    private $crocodocService;

    /**
     * @param CrocodocService $crocodocService
     */
    public function __construct(CrocodocService $crocodocService)
    {
        $this->crocodocService = $crocodocService;
    }

    /**
     * @param Document $document
     * @return string
     */
    public function uploadDocument(Document $document)
    {
        return $this->crocodocService->uploadDocument($document->getAbsolutePath());
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
        // TODO: determine how internship is related to document to authorize
        if (false){
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