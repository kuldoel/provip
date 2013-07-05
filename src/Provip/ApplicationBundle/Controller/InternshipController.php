<?php

namespace Provip\ApplicationBundle\Controller;

use Provip\EventsBundle\Entity\FeedbackEvent;
use Provip\EventsBundle\Entity\Picture;
use Provip\ProvipBundle\Entity\Activity;
use Provip\ProvipBundle\Entity\Application;
use Provip\ProvipBundle\Entity\Internship;
use Provip\ProvipBundle\Entity\Opportunity;
use Provip\ProvipBundle\Entity\Task;
use Provip\ProvipBundle\Form\Type\ActivityNewType;
use Provip\ProvipBundle\Form\Type\ApplicationType;
use Provip\ProvipBundle\Form\Type\CompanyProfileType;
use Provip\UserBundle\Entity\User;
use Provip\UserBundle\Form\Type\CompanyStaffProfileType;
use Provip\UserBundle\Form\Type\NewStaffType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\UserBundle\Mailer\MailerInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class InternshipController extends Controller
{
    /**
     * @Route("/student/internships", options={"expose"=true})
     */
    public function studentInternshipsAction()
    {

        $applications = $this->getUser()->getApplications();
        $internships = $this->getUser()->getInternships();

        return $this->render('ProvipApplicationBundle:Internships:student.html.twig', array('applications' => $applications, 'internships' => $internships));
    }

    /**
     * @Route("/hei/internships", options={"expose"=true})
     */
    public function heiInternshipsAction()
    {

        if( $this->container->get('security.context')->isGranted('ROLE_HEI_STAFF_ADMIN') )
        {
            $applications = $this->getDoctrine()
                ->getRepository('ProvipUserBundle:User')
                ->getApplicationByHei(
                    $this->getUser()->getAdminOf()
                );

            $internships = $this->getDoctrine()
                ->getRepository('ProvipUserBundle:User')
                ->getInternshipByHei(
                    $this->getUser()->getAdminOf()
                );

        }

        else
        {

            $applications = $this->getUser()->getCoaching();

            $internships = $this->getUser()->getCoaching();

        }

        return $this->render('ProvipApplicationBundle:Internships:hei.html.twig', array('applications' => $applications, 'internships' => $internships));
    }

    /**
     * @Route("/company/internships", options={"expose"=true})
     */
    public function companyInternshipsAction()
    {

        if( $this->container->get('security.context')->isGranted('ROLE_COMPANY_STAFF_ADMIN') )
        {
            $applications = $this->getDoctrine()
                ->getRepository('ProvipUserBundle:User')
                ->getApplicationByCompany(
                    $this->getUser()->getCompany()
                );

            $internships = $this->getDoctrine()
                ->getRepository('ProvipUserBundle:User')
                ->getInternshipByCompany(
                    $this->getUser()->getCompany()
                );

        }

        else
        {
            $applications = $this->getUser()->getMentoring();
            $internships = $this->getUser()->getMentoring();
        }

        return $this->render('ProvipApplicationBundle:Internships:company.html.twig', array('applications' => $applications, 'internships' => $internships));
    }

    /**
     * @Route("/student/internships/{publicId}", options={"expose"=true})
     */
    public function detailStudentAction(Internship $internship)
    {

        $application = $internship->getApplication();
        $student     = $internship->getStudent();

        if($this->getUser() != $student)
        {
            return new Response("Not Authorized", 403);
        }

        $opportunity = $application->getOpportunity();

        $activityUpdateEvents = $this->getDoctrine()->getRepository('ProvipUserBundle:User')->getActivityUpdatesEventsForInternship($internship, $student);
        $activities = $this->getDoctrine()->getRepository('ProvipProvipBundle:Task')->getActivitiesForUser($student, $application);

        return $this->render('ProvipApplicationBundle:Internships:charter_student.html.twig', array('opportunity' => $opportunity, 'application' => $application, 'activityUpdateEvents' => $activityUpdateEvents, 'activities' => $activities));

    }


    /**
     * @Route("/company/internships/{publicId}", options={"expose"=true})
     */
    public function detailCompanyAction(Internship $internship)
    {

        $application = $internship->getApplication();
        $student     = $internship->getStudent();

        if($internship->getApplication()->getOpportunity()->getCompany() != $this->getUser()->getCompany())
        {
            return new Response("Not Authorized", 403);
        }

        $opportunity = $application->getOpportunity();

        $activityUpdateEvents = $this->getDoctrine()->getRepository('ProvipUserBundle:User')->getActivityUpdatesEventsForInternshipCompany($internship, $student);
        $activities = $this->getDoctrine()->getRepository('ProvipProvipBundle:Task')->getActivitiesForUser($student, $application);

        return $this->render('ProvipApplicationBundle:Internships:charter_company.html.twig', array('opportunity' => $opportunity, 'application' => $application, 'activityUpdateEvents' => $activityUpdateEvents, 'activities' => $activities, 'student' => $student));

    }

    /**
     * @Route("/hei/internships/{publicId}", options={"expose"=true})
     */
    public function detailHeiAction(Internship $internship)
    {

        $application = $internship->getApplication();
        $student     = $internship->getStudent();



        $opportunity = $application->getOpportunity();

        $activityUpdateEvents = $this->getDoctrine()->getRepository('ProvipUserBundle:User')->getActivityUpdatesEventsForInternshipHei($internship, $student);
        $activities = $this->getDoctrine()->getRepository('ProvipProvipBundle:Task')->getActivitiesForUser($student, $application);

        return $this->render('ProvipApplicationBundle:Internships:charter_hei.html.twig', array('opportunity' => $opportunity, 'application' => $application, 'activityUpdateEvents' => $activityUpdateEvents, 'activities' => $activities, 'student' => $student));

    }




}
