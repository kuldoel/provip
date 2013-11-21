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
use Provip\ProvipBundle\Form\Type\InternshipCompanyType;
use Provip\ProvipBundle\Form\Type\InternshipHeiType;
use Provip\ProvipBundle\Form\Type\InternshipStudentType;
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
use Provip\ProvipBundle\Entity\Document;
use Provip\EventsBundle\Form\Type\DocumentType;
use Symfony\Component\HttpFoundation\File\File;

class InternshipController extends Controller
{
    /**
     * @Route("/student/internships", options={"expose"=true})
     */
    public function studentInternshipsAction()
    {
        if($this->getUser()->getEnrollment()->getApproved() == false)
        {
            $this->get('session')->getFlashBag()->add('danger', 'Your enrollment is not yet approved');
            return $this->redirect($this->generateUrl('provip_application_student_settings'));
        }

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
    public function detailStudentAction(Internship $internship, Request $request)
    {
        if($this->getUser()->getEnrollment()->getApproved() == false)
        {
            $this->get('session')->getFlashBag()->add('danger', 'Your enrollment is not yet approved');
            return $this->redirect($this->generateUrl('provip_application_student_settings'));
        }

        $application = $internship->getApplication();
        $student     = $internship->getStudent();

        if($this->getUser() != $student)
        {
            return new Response("Not Authorized", 403);
        }

        $opportunity = $application->getOpportunity();

        $activityUpdateEvents = $this->getDoctrine()->getRepository('ProvipUserBundle:User')->getActivityUpdatesEventsForInternship($internship, $student);
        $activities = $this->getDoctrine()->getRepository('ProvipProvipBundle:Task')->getActivitiesForUser($student, $application);

        if($internship->getCompleted()) {
            $this->get('session')->getFlashBag()->add('warning', 'This internship has been marked as completed');
        }

        $document = new Document();

        $form = $this->createForm(new DocumentType(), $document);

        if ($request->isMethod('POST')) {

            $form->handleRequest($request);

            $document->g

            if (1) {

                $em = $this->getDoctrine()->getManager();

                $document->setInternship($internship);
                $document->setOwner($this->getUser());

                try {
                    $em->persist($document);
                    $em->flush();

                    $file = new File($document->getFile()->getAbsolutePath());

                    $this->get('session')->getFlashBag()->add('success', 'Your file with mimetype '. $file->getMimeType() . ' has been uploaded');
                    $this->get('provip_crocodoc_service')->uploadDocument($document);
                    return $this->redirect($this->generateUrl('provip_application_internship_detailstudent', array('publicId' => $internship->getPublicId())));
                }
                catch(\PDOException $e) {
                    $this->get('session')->getFlashBag()->add('success', 'There were some errors with your file');
                    return $this->redirect($this->generateUrl('provip_application_internship_detailstudent', array('publicId' => $internship->getPublicId())));
                }

            } else {

                $this->get('session')->getFlashBag()->add('warning', 'There were some errors with your file. Only pdf, ppt, pptx, doc, docx, xls and xlsx files are supported.');
                return $this->redirect($this->generateUrl('provip_application_internship_detailstudent', array('publicId' => $internship->getPublicId())));
            }

        }

        return $this->render(
            'ProvipApplicationBundle:Internships:charter_student.html.twig',
            array(
                'opportunity' => $opportunity,
                'application' => $application,
                'activityUpdateEvents' => $activityUpdateEvents,
                'activities' => $activities,
                'form' => $form->createView()
            )
        );

    }


    /**
     * @Route("/student/internships/{publicId}/evaluation", options={"expose"=true})
     */
    public function evaluationStudentAction(Internship $internship, Request $request)
    {
        if($this->getUser()->getEnrollment()->getApproved() == false)
        {
            $this->get('session')->getFlashBag()->add('danger', 'Your enrollment is not yet approved.');
            return $this->redirect($this->generateUrl('provip_application_student_settings'));
        }

        $application = $internship->getApplication();
        $student     = $internship->getStudent();

        if($this->getUser() != $student)
        {
            $this->get('session')->getFlashBag()->add('danger', 'You cannot access this internship.');
            return $this->redirect($this->generateUrl('provip_application_student_settings'));
        }

        if(!$internship->getCompleted())
        {
            $this->get('session')->getFlashBag()->add('danger', 'This internship is not yet completed.');
            return $this->redirect($this->generateUrl('provip_application_internship_detailstudent', array('publicId' => $internship->getPublicId())));
        }

        $opportunity = $application->getOpportunity();

        $activityUpdateEvents = $this->getDoctrine()->getRepository('ProvipUserBundle:User')->getActivityUpdatesEventsForInternship($internship, $student);
        $activities = $this->getDoctrine()->getRepository('ProvipProvipBundle:Task')->getActivitiesForUser($student, $application);

        $form = $this->createForm(new InternshipStudentType(), $internship);

        if ('POST' === $request->getMethod()) {

            $form->handleRequest($request);


            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($internship);
                $em->flush();

                return new Response($internship->getCommentsByStudent(), '200');

            }
            else
            {
               return new Response('Error saving students comments', 400);

            }
        }

        return $this->render('ProvipApplicationBundle:Internships:evaluation_student.html.twig', array('opportunity' => $opportunity, 'application' => $application, 'activityUpdateEvents' => $activityUpdateEvents, 'activities' => $activities, 'form' => $form->createView()));

    }


    /**
     * @Route("/hei/internships/{publicId}/evaluation", options={"expose"=true})
     */
    public function evaluationHeiAction(Internship $internship, Request $request)
    {

        $application = $internship->getApplication();
        $student     = $internship->getStudent();

        if($this->getUser()->getAdminOf() != $student->getEnrollment()->getStudyProgram() && $this->getUser()->getTeachesAt() != $application->getCoach())
        {
            $this->get('session')->getFlashBag()->add('danger', 'You cannot access this internship.');
            return $this->redirect($this->generateUrl('provip_application_hei_dashboard'));
        }

        if(!$internship->getCompleted())
        {
            $this->get('session')->getFlashBag()->add('danger', 'This internship is not yet completed.');
            return $this->redirect($this->generateUrl('provip_application_internship_detailhei', array('publicId' => $internship->getPublicId())));
        }

        $opportunity = $application->getOpportunity();

        $activityUpdateEvents = $this->getDoctrine()->getRepository('ProvipUserBundle:User')->getActivityUpdatesEventsForInternship($internship, $student);
        $activities = $this->getDoctrine()->getRepository('ProvipProvipBundle:Task')->getActivitiesForUser($student, $application);

        $form = $this->createForm(new InternshipHeiType(), $internship);

        if ('POST' === $request->getMethod()) {

            $form->handleRequest($request);


            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($internship);
                $em->flush();

                return new Response($internship->getCommentsByHei(), '200');

            }
            else
            {
                return new Response('Error saving HEI comments', 400);

            }
        }

        return $this->render('ProvipApplicationBundle:Internships:evaluation_hei.html.twig', array('opportunity' => $opportunity, 'application' => $application, 'activityUpdateEvents' => $activityUpdateEvents, 'activities' => $activities, 'form' => $form->createView()));

    }

    /**
     * @Route("/company/internships/{publicId}/evaluation", options={"expose"=true})
     */
    public function evaluationCompanyAction(Internship $internship, Request $request)
    {

        $application = $internship->getApplication();
        $student     = $internship->getStudent();

        if($this->getUser()->getCompany() != $application->getOpportunity()->getCompany())
        {
            $this->get('session')->getFlashBag()->add('danger', 'You cannot access this internship.');
            return $this->redirect($this->generateUrl('provip_application_company_dashboard'));
        }

        if(!$internship->getCompleted())
        {
            $this->get('session')->getFlashBag()->add('danger', 'This internship is not yet completed.');
            return $this->redirect($this->generateUrl('provip_application_internship_detailcompany', array('publicId' => $internship->getPublicId())));
        }

        $opportunity = $application->getOpportunity();

        $activityUpdateEvents = $this->getDoctrine()->getRepository('ProvipUserBundle:User')->getActivityUpdatesEventsForInternship($internship, $student);
        $activities = $this->getDoctrine()->getRepository('ProvipProvipBundle:Task')->getActivitiesForUser($student, $application);

        $form = $this->createForm(new InternshipCompanyType(), $internship);

        if ('POST' === $request->getMethod()) {

            $form->handleRequest($request);


            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($internship);
                $em->flush();

                return new Response($internship->getCommentsByCompany(), '200');

            }
            else
            {
                return new Response('Error saving Company comments', 400);

            }
        }

        return $this->render('ProvipApplicationBundle:Internships:evaluation_company.html.twig', array('opportunity' => $opportunity, 'application' => $application, 'activityUpdateEvents' => $activityUpdateEvents, 'activities' => $activities, 'form' => $form->createView()));

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
