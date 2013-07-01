<?php


namespace Provip\UserBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Provip\ProvipBundle\Entity\Company;

class UserRepository extends EntityRepository
{

    public function getStaffByPartial($q, Company $company)
    {

        $em = $this->getEntityManager();

        $dql = "SELECT u FROM ProvipUserBundle:User u " .
            " WHERE u.company = ?1 AND ".
            " (u.firstName LIKE ?2 OR u.lastName LIKE ?3)";

        return $em->createQuery($dql)
            ->setParameters(array('1' => $company, '2' => $q.'%', '3' => $q.'%'))
            ->getResult();

    }

    public function findByRole($role) {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('u')
            ->from('ProvipUserBundle:User', 'u')
            ->where('u.roles LIKE :roles')
            ->addOrderBy('u.id', 'desc')
            ->setParameter('roles', '%' . $role . '%');
        return $qb->getQuery()->getResult();
    }

}