<?php

namespace Provip\ApplicationBundle\Controller;

use Provip\EventsBundle\Entity\Picture;
use Provip\ProvipBundle\Entity\Activity;
use Provip\ProvipBundle\Entity\Application;
use Provip\ProvipBundle\Entity\Internship;
use Provip\ProvipBundle\Entity\Opportunity;
use Provip\ProvipBundle\Entity\Task;
use Provip\ProvipBundle\Form\Type\ActivityNewType;
use Provip\ProvipBundle\Form\Type\ApplicationRejectType;
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

class ApplicationController extends Controller
{
    /**
     * @Route("/student/marketplace/{slug}/apply", options={"expose"=true})
     */
    public function applyAction(Opportunity $opportunity, Request $request)
    {

        $application = $this->getUser()->getApplicationForOpportunity($opportunity);

        if(!$application instanceof Application)
        {
            $application = new Application();

            $application->setStudent($this->getUser());
            $application->setOpportunity($opportunity);
            $application->setStartDate($opportunity->getStartDate());
            $application->setEndDate($opportunity->getEndDate());

            $em = $this->getDoctrine()->getManager();

            $em->persist($application);
            $em->flush();
        }


        if(!$opportunity->getPublished())
        {
            return new Response("Opportunity not found", 404);
        }

        $activities = $this->getDoctrine()->getRepository('ProvipProvipBundle:Task')->getActivitiesForUser($this->getUser(), $application);

        $form = $this->createForm(new ApplicationType($this->getUser()), $application);

        if ('POST' === $request->getMethod()) {

            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();

                $application->setSubmittedForReview(true);
                $application->setRejected(false);

                $em->persist($application);
                $em->flush();

                return new Response("", 204);

            }
            else
            {
                return new Response($this->renderView('ProvipApplicationBundle:Widgets:form_errors.html.twig', array('errors' => $form->getErrors())), 400);

            }
        }

        return $this->render('ProvipApplicationBundle:Application:charter.html.twig', array('opportunity' => $opportunity, 'application' => $application, 'activities' => $activities, 'form' => $form->createView()));

    }

    /**
     * @Route("/student/marketplace/add-activity-to-task/{task}/{application}", options={"expose"=true})
     * @ParamConverter("application", class="ProvipProvipBundle:Application", options={"id" = "application"})
     */
    public function addActivityToTaskForApplication(Task $task, Application $application, Request $request)
    {
        $activity = new Activity();
        $form = $this->createForm(new ActivityNewType(), $activity);

        if ('POST' === $request->getMethod()) {

            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();

                $activity->setApplication($application);
                $activity->setTask($task);
                $activity->setStudent($this->getUser());

                $em->persist($activity);
                $em->flush();

                return new Response($this->renderView('ProvipApplicationBundle:Widgets:activity.html.twig', array('activity' => $activity, 'status' => 'new')), 201);

            }
            else
            {
                return new Response($this->renderView('ProvipApplicationBundle:Widgets:form_errors.html.twig', array('errors' => $form->getErrors())), 400);

            }
        }

        return $this->render('ProvipApplicationBundle:Application:new_activity_form.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/student/application/remove/activity/{activity}", options={"expose"=true})
     */
    public function removeActivity(Activity $activity)
    {
        if($this->getUser() == $activity->getStudent())
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($activity);
            $em->flush();

            return new Response("Activity Deleted", 200);
        }
        else
        {
            return new Response("Not Authorized", 403);
        }
    }

    /**
     * @Route("/company/applications/{application}/review", options={"expose"=true})
     */
    public function reviewAsCompanyAction(Application $application, Request $request)
    {

        $form = $this->createForm(new ApplicationRejectType(), $application);

        $opportunity = $application->getOpportunity();
        $student = $application->getStudent();

        if($opportunity->getCompany() != $this->getUser()->getCompany())
        {
            return new Response("Not Authorized", 403);
        }

        if ('POST' === $request->getMethod()) {

            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();

                $application->setRejected(true);
                $application->setSubmittedForReview(false);
                $application->setRejectedBy($application->getOpportunity()->getCompany());

                $em->persist($application);
                $em->flush();

                return new Response('Rejected Complete', 200);

            }
            else
            {
                return new Response($this->renderView('ProvipApplicationBundle:Widgets:form_errors.html.twig', array('errors' => $form->getErrors())), 400);

            }
        }


        $activities = $this->getDoctrine()->getRepository('ProvipProvipBundle:Task')->getActivitiesForUser($application->getStudent(), $application);


        return $this->render('ProvipApplicationBundle:Application:charter_company.html.twig', array('opportunity' => $opportunity, 'application' => $application, 'activities' => $activities, 'student' => $student, 'form' => $form->createView()));

    }


    /**
     * @Route("/company/applications/{application}/accept", options={"expose"=true})
     */
    public function acceptAsCompanyAction(Application $application)
    {


        if($application->getOpportunity()->getCompany() != $this->getUser()->getCompany())
        {
            return new Response("Not Authorized", 403);
        }

        $em = $this->getDoctrine()->getManager();

        $application->setApprovedByCompany(true);
        $application->setRejected(false);
        $application->setRejectionReason(NULL);



        $status = '75';

        if($application->getApprovedByHei())
        {
            $status = '100';
            $internship = $this->createInternship($application);
            $application->setInternship($internship);
        }


        $em->persist($application);
        $em->flush();

        return new Response($status, 200);

    }


    /**
     * @Route("/hei/applications/{application}/accept", options={"expose"=true})
     */
    public function acceptAsHeiAction(Application $application)
    {


        $em = $this->getDoctrine()->getManager();

        $application->setApprovedByHei(true);
        $application->setRejected(false);
        $application->setRejectionReason(NULL);


        $status = '75';

        if($application->getApprovedByCompany())
        {
            $status = '100';
            $internship = $this->createInternship($application);
            $application->setInternship($internship);
        }

        $em->persist($application);
        $em->flush();

        return new Response($status, 200);

    }


    /**
     * @Route("/hei/applications/{application}/review", options={"expose"=true})
     */
    public function reviewAsHei(Application $application, Request $request)
    {

        $form = $this->createForm(new ApplicationRejectType(), $application);

        $opportunity = $application->getOpportunity();
        $student = $application->getStudent();

        if($student->getEnrollment()->getStudyProgram() != $this->getUser()->getAdminOf())
        {
            return new Response("Not Authorized", 403);
        }

        if ('POST' === $request->getMethod()) {

            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();

                $application->setRejected(true);
                $application->setSubmittedForReview(false);
                $application->setRejectedBy($this->getUser()->getAdminOf()->getHigherEducationalInstitution());

                $em->persist($application);
                $em->flush();

                return new Response('Rejected Complete', 200);

            }
            else
            {
                return new Response($this->renderView('ProvipApplicationBundle:Widgets:form_errors.html.twig', array('errors' => $form->getErrors())), 400);

            }
        }


        $activities = $this->getDoctrine()->getRepository('ProvipProvipBundle:Task')->getActivitiesForUser($application->getStudent(), $application);


        return $this->render('ProvipApplicationBundle:Application:charter_hei.html.twig', array('opportunity' => $opportunity, 'application' => $application, 'activities' => $activities, 'student' => $student, 'form' => $form->createView()));

    }

    private function createInternship(Application $application)
    {
        $em = $this->getDoctrine()->getManager();

        $internship = new Internship($application->getStudent(), $application);

        $em->persist($internship);
        $em->flush();

        return $internship;

    }

}
