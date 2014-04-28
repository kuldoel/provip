<?php

namespace Provip\ApplicationBundle\Service;

use Doctrine\ORM\EntityManager;
use Provip\ProvipBundle\Entity\Document;
use Provip\ProvipBundle\Entity\DocumentState;
use Provip\UserBundle\Entity\User;
use SekoiaLearn\CrocodocBundle\Service\CrocodocService;

class ProvipCrocodocService
{
    /**
     * @var CrocodocService
     */
    private $crocodocService;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param CrocodocService $crocodocService
     * @param EntityManager $entityManager
     */
    public function __construct(CrocodocService $crocodocService, EntityManager $entityManager)
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
        $document->setCrocodocId($docId);
        $document->setState(DocumentState::STATE_UPLOADED_TO_CROCODOC);
        $this->entityManager->persist($document);
        $this->entityManager->flush($document);
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
        $internship = $document->getInternship();

        $allowedViewers = array(
            ($internship->getStudent()),
            ($internship->getApplication()->getCoach()),
            ($internship->getApplication()->getOpportunity()->getMentor())
        );

        $admins = $internship->getStudent()->getEnrollment()->getStudyProgram()->getAdmins();

        foreach($admins as $admin) {
            $allowedViewers[] = $admin;
        }

        if( ! in_array($user, $allowedViewers, true) ){
            throw new \LogicException('Unauthorized access');
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
}