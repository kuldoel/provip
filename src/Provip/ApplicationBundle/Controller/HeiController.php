<?php

namespace Provip\ApplicationBundle\Controller;

use Provip\EventsBundle\Entity\Notification;
use Provip\EventsBundle\Entity\Picture;
use Provip\ProvipBundle\Entity\Deliverable;
use Provip\ProvipBundle\Entity\Enrollment;
use Provip\ProvipBundle\Entity\Skill;
use Provip\ProvipBundle\Form\Type\CompanyProfileType;
use Provip\ProvipBundle\Form\Type\DeliverableType;
use Provip\ProvipBundle\Form\Type\HeiProfileType;
use Provip\ProvipBundle\Form\Type\SkillType;
use Provip\ProvipBundle\Form\Type\StudyProgramProfileType;
use Provip\ProvipBundle\Form\Type\StudyProgramType;
use Provip\UserBundle\Entity\User;
use Provip\UserBundle\Form\Type\HeiStaffProfileType;
use Provip\UserBundle\Form\Type\NewStaffType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\UserBundle\Mailer\MailerInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Provip\EventsBundle\Entity\StudentEvent;

class HeiController extends Controller
{

    protected $mailer;
    protected $tokenGenerator;


    /**
     * @Route("/hei")
     */
    public function dashboardAction()
    {
        return $this->render('ProvipApplicationBundle:Hei:index.html.twig');
    }

   /**
    * @Route("/hei/account-settings")
    */
    public function settingsAction(Request $request)
    {

        $user = $this->getUser();
        $form = $this->createForm(new HeiStaffProfileType(), $user);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);

            if($form->isValid())
            {

                $em = $this->getDoctrine()->getManager();

                $user->setProfileComplete(true);

                $em->persist($user);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Your changes were succesfully saved!');
                return $this->redirect($this->generateUrl('provip_application_hei_settings'));

            }

        }


        return $this->render('ProvipApplicationBundle:Hei:settings.html.twig', array(
            'form' => $form->createView()));
    }

    /**
     * @Route("/hei/hei-choose")
     * @Route("/hei/hei-choose/{route}")
     * @Route("/hei/hei-choose/{route}/{studyProgramId}")
     */
    public function chooseAction($route = null, $studyProgramId = null)
    {
        if(!$studyProgramId)
        {
            $studyPrograms = $this->getUser()->getAdminOf();

            return $this->render('ProvipApplicationBundle:Hei:hei_settings_choose.html.twig', array(
                'studyPrograms' => $studyPrograms,
                'route' => $route));
        }
        else
        {
            $this->get('session')->set('spConfig', $studyProgramId);

            if(!$route)
            {
                $route = 'provip_application_hei_info';
            }

            return $this->redirect($this->generateUrl($route));
        }
    }

    /**
     * @Route("/hei/hei-settings", options={"expose"=true})
     */
    public function infoAction(Request $request)
    {
        $repo = $this
            ->getDoctrine()
            ->getRepository('ProvipProvipBundle:StudyProgram');

        $studyProgram = $repo->find($this->get('session')->get('spConfig'));

        $learningGoal = new Deliverable();
        $skill        = new Skill();

        $formGoal           = $this->createForm(new DeliverableType($studyProgram), $learningGoal);
        $formSkill          = $this->createForm(new SkillType(), $skill);
        $formStudyProgram   = $this->createForm(new StudyProgramProfileType(), $studyProgram);


        if($request->isMethod('POST'))
        {
            $em = $this->getDoctrine()->getManager();

            if($request->request->has('provip_provipbundle_studyprogramprofiletype'))
            {
                $formStudyProgram->handleRequest($request);

                if ($formStudyProgram->isValid()) {

                    $em->persist($studyProgram);

                    $em->flush();

                    return new Response("SAVED", 200);

                }
                else
                {
                    return new Response($this->renderView('ProvipApplicationBundle:Widgets:form_errors.html.twig', array(
                            'errors' => $formSkill->getErrors())
                    ), 400);

                }
            }

            if($request->request->has('provip_provipbundle_skilltype'))
            {
                $formSkill->handleRequest($request);

                if ($formSkill->isValid()) {

                    $studyProgram->addSkill($skill);
                    $skill->addStudyProgram($studyProgram);

                    $em->persist($studyProgram);
                    $em->persist($skill);

                    $em->flush();

                    return new Response($this->renderView('ProvipApplicationBundle:Widgets:skill.html.twig', array('skill' => $skill, 'status' => 'new')), 201);

                }
                else
                {
                    return new Response($this->renderView('ProvipApplicationBundle:Widgets:form_errors.html.twig', array(
                        'errors' => $formSkill->getErrors())
                    ), 400);

                }
            }

            if($request->request->has('provip_provipbundle_deliverabletype'))
            {
                $formGoal->handleRequest($request);

                if ($formGoal->isValid()) {

                    foreach($learningGoal->getTasks() as $task)
                    {
                        $task->setDeliverable($learningGoal);
                        $em->persist($task);
                    }


                    $em->persist($learningGoal);
                    $em->flush();

                    return new Response($this->renderView('ProvipApplicationBundle:Widgets:learningGoal.html.twig', array('learninggoal' => $learningGoal, 'status' => 'new')), 201);

                }
                else
                {
                    return new Response($this->renderView('ProvipApplicationBundle:Widgets:form_errors.html.twig', array(
                            'errors' => $formSkill->getErrors())
                    ), 400);

                }
            }

        }


        return $this->render('ProvipApplicationBundle:Hei:hei_settings.html.twig', array(
            'studyProgram' => $studyProgram,
            'formSkill' => $formSkill->createView(),
            'formStudyProgram' => $formStudyProgram->createView(),
            'formGoal' => $formGoal->createView()));
    }

    /**
     * @Route("/hei/account-settings/delete-picture")
     */
    public function deletePictureAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();
        $picture = $user->getPicture();

        if($picture instanceof Picture)

        {
            $user->setPicture(NULL);

            $em->persist($user);
            $em->flush();
        }

        $this->get('session')->getFlashBag()->add('success', 'Your profile picture was succesfully deleted.');
        return $this->redirect($this->generateUrl('provip_application_hei_settings'));

    }


    /**
     * @Route("/hei/staff", options={"expose"=true})
     */
    public function staffAction(Request $request)
    {
        $repo = $this
            ->getDoctrine()
            ->getRepository('ProvipProvipBundle:StudyProgram');

        $studyProgram = $repo->find($this->get('session')->get('spConfig'));

        $staff = $studyProgram->getStaff();

        $user = new User();
        $form = $this->createForm(new NewStaffType($studyProgram), $user);

        if ('POST' === $request->getMethod()) {

            $form->handleRequest($request);

            $user->setPlainPassword(md5(crypt(rand(0, 50000).time())));

            if ($form->isValid()) {

                $this->mailer = $this->get('fos_user.mailer');
                $this->tokenGenerator = $this->get('fos_user.util.token_generator');

                $userManager = $this->get('fos_user.user_manager');

                $user->addRole('ROLE_HEI_STAFF');

                $userManager->updateUser($user);

                if (null === $user->getConfirmationToken()) {
                    /** @var $tokenGenerator \FOS\UserBundle\Util\TokenGeneratorInterface */
                    $user->setConfirmationToken($this->tokenGenerator->generateToken());
                }

                $this->mailer->sendResettingEmailMessage($user);
                $user->setPasswordRequestedAt(new \DateTime());
                $userManager->updateUser($user);

                return new Response($this->renderView('ProvipApplicationBundle:Widgets:staff_member.html.twig', array(
                    'user' => $user, 'status' => 'new')
                ), 201);

            }
            else
            {
                return new Response($this->renderView('ProvipApplicationBundle:Widgets:form_errors.html.twig', array(
                    'errors' => $form->getErrors())
                ), 400);

            }
        }

        return $this->render('ProvipApplicationBundle:Hei:hei_staff.html.twig', array(
            'form' => $form->createView(),
            'staff' => $staff)
        );

    }


    /**
     * @Route("/hei/staff/search/{q}", defaults={"q" = ""}, options={"expose"=true})
     */
    public function searchAction($q)
    {
        $repo = $this
            ->getDoctrine()
            ->getRepository('ProvipProvipBundle:StudyProgram');

        $studyProgram = $repo->find($this->get('session')->get('spConfig'));

        $staff = $this->getDoctrine()->getRepository('ProvipUserBundle:User')->getHeiStaffByPartial($q, $studyProgram);

        return $this->render('ProvipApplicationBundle:Widgets:company_staff_search.html.twig',array('staff' => $staff, 'status' => ''));
    }


    /**
     * @Route("/hei/students/search/{q}", defaults={"q" = ""}, options={"expose"=true})
     */
    public function searchStudentAction($q)
    {
        $repo = $this
            ->getDoctrine()
            ->getRepository('ProvipProvipBundle:StudyProgram');

        $studyProgram = $repo->find($this->get('session')->get('spConfig'));

        $staff = $this->getDoctrine()->getRepository('ProvipUserBundle:User')->getStudentByPartial($q, $studyProgram);

        return $this->render('ProvipApplicationBundle:Widgets:hei_student_search.html.twig',array('staff' => $staff, 'status' => ''));
    }

    /**
     * @Route("/hei/students")
     */
    public function studentsAction(Request $request)
    {
        $repo = $this
            ->getDoctrine()
            ->getRepository('ProvipProvipBundle:StudyProgram');

        $studyProgram = $repo->find($this->get('session')->get('spConfig'));

        $enrollments = $studyProgram->getEnrollments();

        return $this->render('ProvipApplicationBundle:Hei:hei_students.html.twig', array(
                'enrollments' => $enrollments)
        );
    }

    /**
     * @Route("/hei/enrollments/{id}/toggle", options={"expose"=true})
     */
    public function approveAction(Enrollment $enrollment)
    {

        $enrollment->setApproved(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($enrollment);

        $event = new StudentEvent($this->getUser(), 'has approved the enrollment for ' . $enrollment->getStudent()->__toString(), $enrollment->getId(), 'privacy.hei.only', $enrollment->getStudent());

        $recipients = $event->getRecipients();

        foreach($recipients as $r) {

            $notification = new Notification($r,$event, $enrollment->getStudent()->getEmail());
            $em->persist($notification);
        }

        $em->flush();

        return new Response("complete", 200);
    }

    /**
     * @Route("/hei/enrollments/{id}/deny", options={"expose"=true})
     */
    public function denyAction(Enrollment $enrollment)
    {

        $enrollment->setDenied(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($enrollment);

        $event = new StudentEvent($this->getUser(), 'has denied the enrollment for ' . $enrollment->getStudent()->__toString(), $enrollment->getId(), 'privacy.hei.only', $enrollment->getStudent());

        $recipients = $event->getRecipients();

        foreach($recipients as $r) {

            $notification = new Notification($r,$event, $enrollment->getStudent()->getEmail());
            $em->persist($notification);
        }



        $em->flush();

        return new Response("complete", 200);
    }

    /**
     * @Route("/hei/skill/{id}", options={"expose"=true})
     */
    public function deleteSkillAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $skill = $em->getRepository('ProvipProvipBundle:Skill')->find($id);

        if(! $skill){
            return new Response('Skill not found', 404);
        }

        $em->remove($skill);
        $em->flush();

        return new Response('', 200);
    }


    /**
     * @Route("/hei/task/{id}", options={"expose"=true})
     */
    public function deleteTaskAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $task = $em->getRepository('ProvipProvipBundle:Task')->find($id);

        if(! $task){
            return new Response('Task not found', 404);
        }

        $em->remove($task);
        $em->flush();

        return new Response('', 200);
    }

    /**
     * @Route("/hei/staff/{id}/profile", options={"expose"=true})
     */
    public function staffProfileAction(User $user)
    {
        return $this->render('ProvipApplicationBundle:Hei:profile.html.twig', array(
            'user' => $user));
    }


    /**
     * @Route("/hei/opportunities", options={"expose"=true})
     */
    public function heiOpportunitiesAction()
    {
        $repo = $this
            ->getDoctrine()
            ->getRepository('ProvipProvipBundle:Opportunity');


        $opportunities = $repo->findAll();

        return $this->render(
            'ProvipApplicationBundle:Hei:opportunities.html.twig' ,
            array(
                'opportunities' => $opportunities
            )
        );
    }
}
