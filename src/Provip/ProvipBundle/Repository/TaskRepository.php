<?php


namespace Provip\ProvipBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Provip\ProvipBundle\Entity\Application;
use Provip\UserBundle\Entity\User;


class TaskRepository extends EntityRepository
{

    public function getActivitiesForUser(User $user, Application $application)
    {

        $em = $this->getEntityManager();

        $dql = "SELECT a FROM ProvipProvipBundle:Activity a " .
            " WHERE a.student = ?1 AND ".
            " a.application = ?2 ORDER BY a.deadline ASC";

        return $em->createQuery($dql)
            ->setParameters(array('1' => $user, '2' => $application))
            ->getResult();

    }


}