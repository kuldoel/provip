<?php


namespace Provip\UserBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Provip\ProvipBundle\Entity\Company;
use Provip\ProvipBundle\Entity\Internship;
use Provip\ProvipBundle\Entity\StudyProgram;
use Provip\UserBundle\Entity\User;

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

    public function getHeiStaffByPartial($q, StudyProgram $studyProgram)
    {

        $em = $this->getEntityManager();

        $dql = "SELECT u FROM ProvipUserBundle:User u " .
            " WHERE u.teachesAt = ?1 AND ".
            " (u.firstName LIKE ?2 OR u.lastName LIKE ?3)";

        return $em->createQuery($dql)
            ->setParameters(array('1' => $studyProgram, '2' => $q.'%', '3' => $q.'%'))
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

    public function getApplicationByHei($studyProgram)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select(array('a', 'st', 'en'))
            ->from('ProvipProvipBundle:Application', 'a')
            ->leftjoin('a.student', 'st')
            ->leftJoin('st.enrollment', 'en')
            ->where('en.studyProgram = ?1')
            ->addOrderBy('a.id', 'desc')
            ->setParameter('1', $studyProgram);
        return $qb->getQuery()->getResult();
    }

    public function getInternshipByHei($studyProgram)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select(array('a', 'st', 'en'))
            ->from('ProvipProvipBundle:Application', 'a')
            ->leftjoin('a.student', 'st')
            ->leftJoin('st.enrollment', 'en')
            ->where('en.studyProgram = ?1')
            ->andWhere('a.approvedByHei = 1')
            ->andWhere('a.approvedByCompany = 1')
            ->addOrderBy('a.id', 'desc')
            ->setParameter('1', $studyProgram);
        return $qb->getQuery()->getResult();
    }


    public function getApplicationByCompany($company)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select(array('a', 'o'))
            ->from('ProvipProvipBundle:Application', 'a')
            ->leftjoin('a.opportunity', 'o')
            ->where('o.company = ?1')
            ->addOrderBy('a.id', 'desc')
            ->setParameter('1', $company);
        return $qb->getQuery()->getResult();
    }

    public function getInternshipByCompany($company)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select(array('a', 'o'))
            ->from('ProvipProvipBundle:Application', 'a')
            ->leftjoin('a.opportunity', 'o')
            ->where('o.company = ?1')
            ->andWhere('a.approvedByHei = 1')
            ->andWhere('a.approvedByCompany = 1')
            ->addOrderBy('a.id', 'desc')
            ->setParameter('1', $company);
        return $qb->getQuery()->getResult();
    }


    public function getActivityUpdatesEventsForInternship(Internship $internship, User $user)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select(array('au', 'a', 'ap'))
            ->from('ProvipEventsBundle:ActivityUpdateEvent', 'au')
            ->join('au.activity', 'a')
            ->join('a.application', 'ap')
            ->where('ap.internship = ?1')
            ->andWhere('a.student = ?2')
            ->addOrderBy('au.created', 'desc')
            ->setParameters(array('1' => $internship, '2' => $user))
        ;
        return $qb->getQuery()->getResult();
    }

    public function getActivityUpdatesEventsForInternshipCompany(Internship $internship, User $user)
    {

        $privacy = array('privacy.internship', 'privacy.company.only');

        $qb = $this->_em->createQueryBuilder();
        $qb->select(array('au', 'a', 'ap'))
            ->from('ProvipEventsBundle:ActivityUpdateEvent', 'au')
            ->join('au.activity', 'a')
            ->join('a.application', 'ap')
            ->where('au.privacy IN (:settings)')
            ->andwhere('ap.internship = ?1')
            ->andWhere('a.student = ?2')
            ->addOrderBy('au.created', 'desc')
            ->setParameters(array('settings' => $privacy, '1' => $internship, '2' => $user))
        ;
        return $qb->getQuery()->getResult();

    }

    public function getActivityUpdatesEventsForInternshipHei(Internship $internship, User $user)
    {

        $privacy = array('privacy.internship', 'privacy.hei.only');

        $qb = $this->_em->createQueryBuilder();
        $qb->select(array('au', 'a', 'ap'))
            ->from('ProvipEventsBundle:ActivityUpdateEvent', 'au')
            ->join('au.activity', 'a')
            ->join('a.application', 'ap')
            ->where('au.privacy IN (:settings)')
            ->andwhere('ap.internship = ?1')
            ->andWhere('a.student = ?2')
            ->addOrderBy('au.created', 'desc')
            ->setParameters(array('settings' => $privacy, '1' => $internship, '2' => $user))
        ;
        return $qb->getQuery()->getResult();

    }





}